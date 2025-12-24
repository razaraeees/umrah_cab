<?php

namespace App\Livewire\Admin\Booking;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\Bookings;
use App\Models\CarDetails;
use App\Models\PickUpLocation;
use App\Models\DropLocation;
use App\Models\Hotel;
use App\Models\City;
use App\Models\RouteFares;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class BookingEdit extends Component
{
    public $bookingId;
    public $booking;

    // Customer Information
    #[Validate('required|string|max:255')]
    public $guest_name = '';

    #[Validate('required|string|max:20')]
    public $guest_phone = '';

    #[Validate('nullable|string|max:20')]
    public $guest_whatsapp = '';

    // Route Information
    #[Validate('required|exists:pick_up_locations,id')]
    public $pickup_location_id = '';

    public $pickup_location_name = '';
    public $pickup_location_type = '';

    #[Validate('nullable|exists:cities,id')]
    public $pickup_city_id = '';

    #[Validate('nullable|string|max:255')]
    public $pickup_hotel_name = '';

    #[Validate('required|exists:drop_locations,id')]
    public $dropoff_location_id = '';

    public $dropoff_location_name = '';
    public $dropoff_location_type = '';

    #[Validate('nullable|exists:cities,id')]
    public $dropoff_city_id = '';

    #[Validate('nullable|string|max:255')]
    public $dropoff_hotel_name = '';

    // Vehicle Information
    #[Validate('required|exists:car_details,id')]
    public $vehicle_id = '';

    public $vehicle_name = '';

    #[Validate('required|numeric|min:0')]
    public $price = '';

    // Passenger Information
    #[Validate('required|integer|min:1|max:50')]
    public $no_of_adults = 1;

    #[Validate('required|integer|min:0|max:50')]
    public $no_of_children = 0;

    #[Validate('required|integer|min:0|max:50')]
    public $no_of_infants = 0;

    public $total_passengers = 0;

    // Schedule Information
    #[Validate('required|date|after_or_equal:today')]
    public $pickup_date = '';

    #[Validate('required')]
    public $pickup_time = '';

    // Flight Information
    #[Validate('nullable|string|max:255')]
    public $airline_name = '';

    #[Validate('nullable|string|max:50')]
    public $flight_number = '';

    #[Validate('nullable|date|after_or_equal:today')]
    public $arrival_departure_date = '';

    #[Validate('nullable')]
    public $arrival_departure_time = '';

    #[Validate('nullable|string|max:1000')]
    public $flight_details = '';

    // Additional Information
    #[Validate('required|in:pending,confirmed,cancelled,completed')]
    public $booking_status = 'pending';

    #[Validate('nullable|numeric|min:0')]
    public $recived_paymnet = '';

    #[Validate('nullable|string|max:2000')]
    public $extra_information = '';

    /**
     * Mount component with booking data
     */
    public function mount($id)
    {
        $this->bookingId = $id;
        $this->loadBooking();
    }

    /**
     * Load existing booking data
     */
    private function loadBooking()
    {
        $this->booking = Bookings::with(['pickupLocation', 'dropoffLocation', 'vehicle'])
            ->findOrFail($this->bookingId);

        // Customer Information
        $this->guest_name = $this->booking->guest_name ?? '';
        $this->guest_phone = $this->stripPhonePrefix($this->booking->guest_phone ?? '');
        $this->guest_whatsapp = $this->stripPhonePrefix($this->booking->guest_whatsapp ?? '');

        // Route Information - Pickup
        $this->pickup_location_id = $this->booking->pickup_location_id ?? '';
        $this->pickup_location_name = $this->booking->pickup_location_name ?? '';
        $this->pickup_hotel_name = $this->booking->pickup_hotel_name ?? '';

        // Get pickup city if hotel exists
        if ($this->pickup_hotel_name) {
            $hotel = Hotel::where('name', $this->pickup_hotel_name)->first();
            $this->pickup_city_id = $hotel ? $hotel->city_id : '';
        }

        // Route Information - Dropoff
        $this->dropoff_location_id = $this->booking->dropoff_location_id ?? '';
        $this->dropoff_location_name = $this->booking->dropoff_location_name ?? '';
        $this->dropoff_hotel_name = $this->booking->dropoff_hotel_name ?? '';

        // Get dropoff city if hotel exists
        if ($this->dropoff_hotel_name) {
            $hotel = Hotel::where('name', $this->dropoff_hotel_name)->first();
            $this->dropoff_city_id = $hotel ? $hotel->city_id : '';
        }

        // Vehicle Information
        $this->vehicle_id = $this->booking->vehicle_id ?? '';
        $this->vehicle_name = $this->booking->vehicle_name ?? '';
        $this->price = $this->booking->price ?? '';

        // Passenger Information
        $this->no_of_adults = $this->booking->no_of_adults ?? 1;
        $this->no_of_children = $this->booking->no_of_children ?? 0;
        $this->no_of_infants = $this->booking->no_of_infants ?? 0;
        $this->total_passengers = $this->booking->total_passengers ?? 0;

        // Schedule Information
        $this->pickup_date = $this->booking->pickup_date ?? '';
        $this->pickup_time = $this->booking->pickup_time ?? '';

        // Flight Information
        $this->airline_name = $this->booking->airline_name ?? '';
        $this->flight_number = $this->booking->flight_number ?? '';
        $this->flight_details = $this->booking->flight_details ?? '';
        $this->arrival_departure_date = $this->booking->arrival_departure_date ?? '';
        $this->arrival_departure_time = $this->booking->arrival_departure_time ?? '';

        // Additional Information
        $this->booking_status = $this->booking->booking_status ?? 'pending';
        $this->recived_paymnet = $this->booking->recived_paymnet ?? '';
        $this->extra_information = $this->booking->extra_information ?? '';

        // Set location types
        $this->setLocationTypes();

        // Calculate total passengers
        $this->calculateTotalPassengers();
    }

    /**
     * Strip + prefix from phone number for display
     */
    private function stripPhonePrefix($phone)
    {
        return ltrim($phone, '+');
    }

    /**
     * Set location types based on loaded data
     */
    private function setLocationTypes()
    {
        if ($this->pickup_location_id) {
            $pickupLocation = PickUpLocation::find($this->pickup_location_id);
            $this->pickup_location_type = $pickupLocation ? $pickupLocation->type : '';
        }

        if ($this->dropoff_location_id) {
            $dropoffLocation = DropLocation::find($this->dropoff_location_id);
            $this->dropoff_location_type = $dropoffLocation ? $dropoffLocation->type : '';
        }
    }

    /**
     * Updated pickup location
     */
    public function updatedPickupLocationId($value)
    {
        if (!$value) {
            $this->pickup_location_type = '';
            $this->pickup_hotel_name = '';
            $this->pickup_city_id = '';
            $this->clearFlightInfo();
            return;
        }

        $pickup = PickUpLocation::find($value);
        if ($pickup) {
            $this->pickup_location_type = $pickup->type;
            $this->pickup_location_name = $pickup->pickup_location;

            // Agar Hotel type nahi hai to hotel fields clear karo
            if ($pickup->type !== 'Hotel') {
                $this->pickup_hotel_name = '';
                $this->pickup_city_id = '';
            }

            // Agar Airport type nahi hai to flight info clear karo
            if ($pickup->type !== 'Airport') {
                $this->clearFlightInfo();
            }
        }

        $this->calculatePrice();
    }

    /**
     * Updated dropoff location
     */
    public function updatedDropoffLocationId($value)
    {
        if (!$value) {
            $this->dropoff_location_type = '';
            $this->dropoff_hotel_name = '';
            $this->dropoff_city_id = '';
            return;
        }

        $dropoff = DropLocation::find($value);
        if ($dropoff) {
            $this->dropoff_location_type = $dropoff->type;
            $this->dropoff_location_name = $dropoff->drop_off_location;

            // Agar Hotel type nahi hai to hotel fields clear karo
            if ($dropoff->type !== 'Hotel') {
                $this->dropoff_hotel_name = '';
                $this->dropoff_city_id = '';
            }
        }

        $this->calculatePrice();
    }

    /**
     * Updated pickup city
     */
    public function updatedPickupCityId($value)
    {
        // City change hone par hotel clear nahi karo
        // Alpine.js handle karega filtering
    }

    /**
     * Updated dropoff city
     */
    public function updatedDropoffCityId($value)
    {
        // City change hone par hotel clear nahi karo
        // Alpine.js handle karega filtering
    }

    /**
     * Updated pickup hotel
     */
    public function updatedPickupHotelName($value)
    {
        if ($value) {
            $hotel = Hotel::where('name', $value)->first();
            if ($hotel) {
                $this->pickup_city_id = $hotel->city_id;
            }
        }
    }

    /**
     * Updated dropoff hotel
     */
    public function updatedDropoffHotelName($value)
    {
        if ($value) {
            $hotel = Hotel::where('name', $value)->first();
            if ($hotel) {
                $this->dropoff_city_id = $hotel->city_id;
            }
        }
    }

    /**
     * Updated vehicle
     */
    public function updatedVehicleId($value)
    {
        if (!$value) {
            $this->vehicle_name = '';
            $this->price = '';
            return;
        }

        $vehicle = CarDetails::find($value);
        if ($vehicle) {
            $this->vehicle_name = $vehicle->name . ' - ' . $vehicle->model_variant;
            $this->validatePassengerCapacity($vehicle->seating_capacity);
        }

        $this->calculatePrice();
    }

    /**
     * Calculate price based on route fare
     */
    private function calculatePrice()
    {
        if (!$this->pickup_location_id || !$this->dropoff_location_id || !$this->vehicle_id) {
            return;
        }

        $routeFare = RouteFares::where('pickup_id', $this->pickup_location_id)
            ->where('dropoff_id', $this->dropoff_location_id)
            ->where('vehicle_id', $this->vehicle_id)
            ->where('status', 'active')
            ->first();

        $this->price = $routeFare ? $routeFare->amount : 0;
    }

    /**
     * Validate passenger capacity
     */
    private function validatePassengerCapacity($vehicleCapacity)
    {
        $this->calculateTotalPassengers();

        if ($this->total_passengers > $vehicleCapacity) {
            $this->addError('no_of_adults', "Total passengers ({$this->total_passengers}) exceed vehicle capacity ({$vehicleCapacity})");
        }
    }

    /**
     * Updated passenger counts
     */
    public function updatedNoOfAdults()
    {
        $this->calculateTotalPassengers();
        $this->validateCurrentCapacity();
    }

    public function updatedNoOfChildren()
    {
        $this->calculateTotalPassengers();
        $this->validateCurrentCapacity();
    }

    public function updatedNoOfInfants()
    {
        $this->calculateTotalPassengers();
        $this->validateCurrentCapacity();
    }

    /**
     * Calculate total passengers
     */
    private function calculateTotalPassengers()
    {
        $this->total_passengers = (int) $this->no_of_adults
            + (int) $this->no_of_children
            + (int) $this->no_of_infants;
    }

    /**
     * Validate current vehicle capacity
     */
    private function validateCurrentCapacity()
    {
        if ($this->vehicle_id) {
            $vehicle = CarDetails::find($this->vehicle_id);
            if ($vehicle) {
                $this->validatePassengerCapacity($vehicle->seating_capacity);
            }
        }
    }

    /**
     * Clear flight information
     */
    private function clearFlightInfo()
    {
        $this->airline_name = '';
        $this->flight_number = '';
        $this->flight_details = '';
        $this->arrival_departure_date = '';
        $this->arrival_departure_time = '';
    }

    /**
     * Update booking
     */
    public function update()
    {
        $this->validate();

        $this->calculateTotalPassengers();

        if ($this->total_passengers < 1) {
            $this->addError('no_of_adults', 'At least one passenger is required.');
            return;
        }

        if ($this->vehicle_id) {
            $vehicle = CarDetails::find($this->vehicle_id);
            if ($vehicle && $this->total_passengers > $vehicle->seating_capacity) {
                $this->addError('no_of_adults', "Total passengers exceed vehicle capacity.");
                return;
            }
        }

        try {
            DB::beginTransaction();

            $guestPhone = $this->formatPhoneNumber($this->guest_phone);
            $guestWhatsapp = $this->guest_whatsapp
                ? $this->formatPhoneNumber($this->guest_whatsapp)
                : $guestPhone;

            $this->booking->update([
                'guest_name' => trim($this->guest_name),
                'guest_phone' => $guestPhone,
                'guest_whatsapp' => $guestWhatsapp,
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
                'recived_paymnet' => $this->recived_paymnet ?? 0,
                'updated_by' => Auth::id(),
            ]);

            DB::commit();

            session()->flash('message', "Booking #{$this->booking->id} updated successfully!");

            return redirect()->route('booking.index');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Booking update failed', [
                'booking_id' => $this->bookingId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            session()->flash('error', 'Failed to update booking. Please try again.');

            $this->addError('update', 'An error occurred while updating the booking.');
        }
    }

    /**
     * Format phone number (ensure it has + prefix)
     */
    private function formatPhoneNumber($phone)
    {
        $phone = preg_replace('/[^0-9+]/', '', $phone);
        return strpos($phone, '+') === 0 ? $phone : '+' . $phone;
    }

    /**
     * Render component
     */
    public function render()
    {
        // Get all route fares for editing
        $routeFares = RouteFares::where('status', 'active')
            ->with(['pickupLocation', 'dropoffLocation', 'vehicle'])
            ->get();

        $pickupLocationIds = $routeFares->pluck('pickup_id')->unique();
        $dropoffLocationIds = $routeFares->pluck('dropoff_id')->unique();
        $vehicleIds = $routeFares->pluck('vehicle_id')->unique();

        $pickupLocations = PickUpLocation::whereIn('id', $pickupLocationIds)
            ->where('status', 'active')
            ->orderBy('pickup_location')
            ->get();

        $dropoffLocations = DropLocation::whereIn('id', $dropoffLocationIds)
            ->where('status', 'active')
            ->orderBy('drop_off_location')
            ->get();

        // Get ALL vehicles for dynamic filtering
        $vehicles = CarDetails::orderBy('name')
            ->get();

        $cities = City::where('status', 1)
            ->orderBy('name')
            ->get();

        $hotels = Hotel::where('status', 1)
            ->with('city')
            ->orderBy('name')
            ->get();

        return view('livewire.admin.booking.booking-edit', [
            'booking' => $this->booking,
            'routeFares' => $routeFares,
            'pickupLocations' => $pickupLocations,
            'dropoffLocations' => $dropoffLocations,
            'vehicles' => $vehicles,
            'cities' => $cities,
            'hotels' => $hotels,
        ]);
    }
}