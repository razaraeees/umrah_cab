<?php

namespace App\Livewire\Admin\Booking;

use Livewire\Component;
use App\Models\Bookings;
use App\Models\CarDetails;
use App\Models\PickUpLocation;
use App\Models\DropLocation;
use App\Models\Hotel;
use App\Models\City;
use App\Models\RouteFares;

class BookingCreate extends Component
{
    public $guest_name;
    public $guest_phone;
    public $guest_whatsapp;
    public $copy_contact_to_whatsapp = false;
    public $pickup_location_id;
    public $pickup_location_name;
    public $pickup_hotel_name;
    public $dropoff_location_id;
    public $dropoff_location_name;
    public $dropoff_hotel_name;
    public $vehicle_id;
    public $vehicle_name;
    public $no_of_children = 0;
    public $no_of_infants = 0;
    public $no_of_adults = 1;
    public $total_passengers;
    public $pickup_date;
    public $pickup_time;
    public $airline_name;
    public $flight_number;
    public $flight_details;
    public $arrival_departure_date;
    public $arrival_departure_time;
    public $extra_information;
    public $booking_status = 'pending';
    public $price;
    public $recived_paymnet;

    public $pickup_location_type;
    public $dropoff_location_type;
    public $pickup_city_id;
    public $dropoff_city_id;

    protected $rules = [
        'guest_name' => 'required|string|max:255',
        'guest_phone' => 'required|string|max:20',
        'guest_whatsapp' => 'nullable|string|max:20',
        'pickup_location_id' => 'required|exists:pick_up_locations,id',
        'pickup_hotel_name' => 'nullable|string|max:255',
        'dropoff_location_id' => 'required|exists:drop_locations,id',
        'dropoff_hotel_name' => 'nullable|string|max:255',
        'vehicle_id' => 'required|exists:car_details,id',
        'no_of_adults' => 'required|integer|min:1',
        'no_of_children' => 'required|integer|min:0',
        'no_of_infants' => 'required|integer|min:0',
        'pickup_date' => 'required|date',
        'pickup_time' => 'required',
        'airline_name' => 'nullable|string|max:255',
        'flight_number' => 'nullable|string|max:50',
        'flight_details' => 'nullable|string',
        'arrival_departure_date' => 'nullable|date',
        'arrival_departure_time' => 'nullable',
        'extra_information' => 'nullable|string',
        'booking_status' => 'required|in:pending,confirmed,cancelled,completed',
        'price' => 'required|numeric|min:0',
        'recived_paymnet' => 'nullable|numeric|min:0',
    ];

    public function render()
    {
        // Get all active route fares
        $routeFares = RouteFares::where('status', 'active')
            ->where(function($query) {
                $query->whereNull('start_date')
                    ->orWhere('start_date', '<=', now());
            })
            ->where(function($query) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            })
            ->with(['pickupLocation', 'dropoffLocation', 'vehicle'])
            ->get();

        // Filter locations and vehicles based on route fares
        $pickupLocationIds = $routeFares->pluck('pickup_id')->unique();
        $dropoffLocationIds = $routeFares->pluck('dropoff_id')->unique();
        $vehicleIds = $routeFares->pluck('vehicle_id')->unique();

        $pickupLocations = PickUpLocation::whereIn('id', $pickupLocationIds)
            ->where('status', 'active')
            ->get();

        $dropoffLocations = DropLocation::whereIn('id', $dropoffLocationIds)
            ->where('status', 'active')
            ->get();

        $vehicles = CarDetails::whereIn('id', $vehicleIds)->get();

        $cities = City::where('status', 1)->get();
        $hotels = Hotel::where('status', 1)->with('city')->get();

        return view('livewire.admin.booking.booking-create', compact('vehicles', 'pickupLocations', 'dropoffLocations', 'hotels', 'cities', 'routeFares'));
    }

    public function updatedPickupLocationId($value)
    {
        $pickupLocation = PickUpLocation::find($value);
        $this->pickup_location_name = $pickupLocation ? $pickupLocation->pickup_location : '';
        $this->pickup_location_type = $pickupLocation ? $pickupLocation->type : '';
        
        // Clear hotel name if not hotel type
        if ($this->pickup_location_type !== 'Hotel') {
            $this->pickup_hotel_name = '';
        }
        
        // Clear dependent fields when pickup location changes
        $this->dropoff_location_id = '';
        $this->dropoff_location_name = '';
        $this->vehicle_id = '';
        $this->vehicle_name = '';
        $this->price = '';
    }

    public function updatedDropoffLocationId($value)
    {
        $dropoffLocation = DropLocation::find($value);
        $this->dropoff_location_name = $dropoffLocation ? $dropoffLocation->drop_off_location : '';
        $this->dropoff_location_type = $dropoffLocation ? $dropoffLocation->type : '';
        
        // Clear hotel name if not hotel type
        if ($this->dropoff_location_type !== 'Hotel') {
            $this->dropoff_hotel_name = '';
        }
        
        // Clear vehicle and price when dropoff location changes
        $this->vehicle_id = '';
        $this->vehicle_name = '';
        $this->price = '';
    }

    public function updatedVehicleId($value)
    {
        $vehicle = CarDetails::find($value);
        $this->vehicle_name = $vehicle ? $vehicle->name : '';
        
        // Calculate price based on route fare
        $this->calculatePrice();
    }
    
    public function calculatePrice()
    {
        if ($this->pickup_location_id && $this->dropoff_location_id && $this->vehicle_id) {
            $routeFare = RouteFares::where('pickup_id', $this->pickup_location_id)
                ->where('dropoff_id', $this->dropoff_location_id)
                ->where('vehicle_id', $this->vehicle_id)
                ->where('status', 'active')
                ->where(function($query) {
                    $query->whereNull('start_date')
                        ->orWhere('start_date', '<=', now());
                })
                ->where(function($query) {
                    $query->whereNull('end_date')
                        ->orWhere('end_date', '>=', now());
                })
                ->first();
                
            if ($routeFare) {
                $this->price = $routeFare->amount;
            } else {
                $this->price = '';
            }
        }
    }

    public function updatedNoOfAdults()
    {
        $this->calculateTotalPassengers();
    }

    public function updatedNoOfChildren()
    {
        $this->calculateTotalPassengers();
    }

    public function updatedNoOfInfants()
    {
        $this->calculateTotalPassengers();
    }

    private function    calculateTotalPassengers()
    {
        $this->total_passengers = $this->no_of_adults + $this->no_of_children + $this->no_of_infants;
    }

    public function save()
    {
        $this->validate();

        $this->calculateTotalPassengers();

        Bookings::create([
            'guest_name' => $this->guest_name,
            'guest_phone' => $this->guest_phone,
            'guest_whatsapp' => $this->guest_whatsapp,
            'pickup_location_id' => $this->pickup_location_id,
            'pickup_location_name' => $this->pickup_location_name,
            'pickup_hotel_name' => $this->pickup_hotel_name,
            'dropoff_location_id' => $this->dropoff_location_id,
            'dropoff_location_name' => $this->dropoff_location_name,
            'dropoff_hotel_name' => $this->dropoff_hotel_name,
            'vehicle_id' => $this->vehicle_id,
            'vehicle_name' => $this->vehicle_name,
            'no_of_children' => $this->no_of_children,
            'no_of_infants' => $this->no_of_infants,
            'no_of_adults' => $this->no_of_adults,
            'total_passengers' => $this->total_passengers,
            'pickup_date' => $this->pickup_date,
            'pickup_time' => $this->pickup_time,
            'airline_name' => $this->airline_name,
            'flight_number' => $this->flight_number,
            'flight_details' => $this->flight_details,
            'arrival_departure_date' => $this->arrival_departure_date,
            'arrival_departure_time' => $this->arrival_departure_time,
            'extra_information' => $this->extra_information,
            'booking_status' => $this->booking_status,
            'price' => $this->price,
            'recived_paymnet' => $this->recived_paymnet,
        ]);

        session()->flash('message', 'Booking created successfully.');

        return redirect()->route('booking.index');
    }
}
