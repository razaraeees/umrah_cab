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
use App\Models\AdditionalService;
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

    #[Validate('required|string|max:20|regex:/^\+?[0-9]{10,15}$/')]
    public $guest_phone = '';

    #[Validate('nullable|string|max:20|regex:/^\+?[0-9]{10,15}$/')]
    public $guest_whatsapp = '';

    #[Validate('required|in:credit,cash')]
    public $payment_type = 'credit';

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

    #[Validate('required|date_format:H:i')]
    public $pickup_time = '';

    // Flight Information
    #[Validate('nullable|string|max:255')]
    public $airline_name = '';

    #[Validate('nullable|string|max:50')]
    public $flight_number = '';

    #[Validate('nullable|date|after_or_equal:today')]
    public $arrival_departure_date = '';

    #[Validate('nullable|date_format:H:i')]
    public $arrival_departure_time = '';

    #[Validate('nullable|string|max:1000')]
    public $flight_details = '';

    // Additional Information
    #[Validate('required|in:pending,confirmed,cancelled,completed')]
    public $booking_status = 'pending';

    #[Validate('nullable|numeric|min:0')]
    public $received_payment = 0;

    #[Validate('nullable|string|max:2000')]
    public $extra_information = '';

    // Additional Services & Calculation
    public $additionalServicesList = [];
    public $selectedServices = [];
    public $totalAmount = 0;
    
    #[Validate('nullable|numeric|min:0')]
    public $discountAmount = 0;

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
        $this->booking = Bookings::with(['pickupLocation', 'dropoffLocation', 'vehicle', 'additionalServices'])
            ->findOrFail($this->bookingId);

        // Customer Information
        $this->guest_name = $this->booking->guest_name ?? '';
        $this->guest_phone = $this->stripPhonePrefix($this->booking->guest_phone ?? '');
        $this->guest_whatsapp = $this->stripPhonePrefix($this->booking->guest_whatsapp ?? '');
        $this->payment_type = $this->booking->payment_type ?? 'credit';

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
        $this->pickup_time = $this->booking->pickup_time ? \Carbon\Carbon::parse($this->booking->pickup_time)->format('H:i') : '';

        // Flight Information
        $this->airline_name = $this->booking->airline_name ?? '';
        $this->flight_number = $this->booking->flight_number ?? '';
        $this->flight_details = $this->booking->flight_details ?? '';
        $this->arrival_departure_date = $this->booking->arrival_departure_date ?? '';
        $this->arrival_departure_time = $this->booking->arrival_departure_time ? \Carbon\Carbon::parse($this->booking->arrival_departure_time)->format('H:i') : '';

        // Additional Information
        $this->booking_status = $this->booking->booking_status ?? 'pending';
        $this->received_payment = $this->booking->recived_paymnet ?? 0;
        $this->extra_information = $this->booking->extra_information ?? '';
        
        // New Fields
        $this->totalAmount = $this->booking->total_amount ?? 0;
        $this->discountAmount = $this->booking->discount_amount ?? 0;

        // Load Services
        $this->loadAdditionalServices();
        $this->selectedServices = $this->booking->additionalServices->pluck('id')->toArray();

        // Set location types
        $this->setLocationTypes();

        // Calculate total passengers
        $this->calculateTotalPassengers();

        // Calculate total amount ensures consistency
        $this->calculateTotalAmount();
    }
    
    /**
     * Load additional services
     */
    private function loadAdditionalServices()
    {
        $this->additionalServicesList = AdditionalService::where('status', 1)
            ->orderBy('services')
            ->get();
    }

    /**
     * Watch for selected services changes
     */
    public function updatedSelectedServices()
    {
        $this->calculateTotalAmount();
    }

    /**
     * Watch for discount changes
     */
    public function updatedDiscountAmount()
    {
        $this->calculateTotalAmount();
    }

    /**
     * Watch for price changes
     */
    public function updatedPrice()
    {
        $this->calculateTotalAmount();
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
            $this->resetPickupData();
            return;
        }

        $pickupLocation = PickUpLocation::find($value);

        if (!$pickupLocation) {
            $this->addError('pickup_location_id', 'Invalid pickup location selected.');
            $this->resetPickupData();
            return;
        }

        $this->pickup_location_name = $pickupLocation->pickup_location;
        $this->pickup_location_type = $pickupLocation->type;

        // Clear hotel name if not hotel type
        if ($this->pickup_location_type !== 'Hotel') {
            $this->pickup_hotel_name = '';
            $this->pickup_city_id = '';
        }

        // Clear flight info if not airport
        if ($this->pickup_location_type !== 'Airport') {
            $this->clearFlightInfo();
        }

        // Reset dependent fields
        $this->resetDropoffAndVehicleData();
    }

    /**
     * Updated dropoff location
     */
    public function updatedDropoffLocationId($value)
    {
        if (!$value) {
            $this->resetDropoffData();
            return;
        }

        $dropoffLocation = DropLocation::find($value);

        if (!$dropoffLocation) {
            $this->addError('dropoff_location_id', 'Invalid dropoff location selected.');
            $this->resetDropoffData();
            return;
        }

        $this->dropoff_location_name = $dropoffLocation->drop_off_location;
        $this->dropoff_location_type = $dropoffLocation->type;

        // Clear hotel name if not hotel type
        if ($this->dropoff_location_type !== 'Hotel') {
            $this->dropoff_hotel_name = '';
            $this->dropoff_city_id = '';
        }

        // Reset vehicle and price
        $this->resetVehicleData();
        
        // Try to calculate price if vehicle is already selected
        if ($this->vehicle_id) {
            $this->calculatePrice();
        }
    }

    /**
     * Updated vehicle
     */
    public function updatedVehicleId($value)
    {
        if (!$value) {
            $this->resetVehicleData();
            return;
        }

        $vehicle = CarDetails::find($value);

        if (!$vehicle) {
            $this->addError('vehicle_id', 'Invalid vehicle selected.');
            $this->resetVehicleData();
            return;
        }

        $this->vehicle_name = "{$vehicle->name} - {$vehicle->model_variant}";
        
        // Validate passenger capacity
        if (!$this->validatePassengerCapacity($vehicle->seating_capacity)) {
            return;
        }

        $this->calculatePrice();
    }

    /**
     * Calculate price based on route fare
     */
    public function calculatePrice()
    {
        // Reset price and errors
        $this->resetErrorBag('price');
        
        if (!$this->pickup_location_id || !$this->dropoff_location_id || !$this->vehicle_id) {
            $this->price = '';
            $this->totalAmount = 0;
            
            if ($this->vehicle_id && (!$this->pickup_location_id || !$this->dropoff_location_id)) {
                $this->addError('price', 'Please select both pickup and dropoff locations first.');
            }
            return;
        }

        $routeFare = RouteFares::where('pickup_id', $this->pickup_location_id)
            ->where('dropoff_id', $this->dropoff_location_id)
            ->where('vehicle_id', $this->vehicle_id)
            ->where('status', 'active')
            ->where(function ($query) {
                $query->whereNull('start_date')
                    ->orWhere('start_date', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            })
            ->first();

        if (!$routeFare) {
            $this->price = '';
            $this->totalAmount = 0;
            $this->addError('price', 'No fare available for this route and vehicle combination. Please contact admin.');
            return;
        }

        $this->price = $routeFare->amount;
        $this->calculateTotalAmount();
    }

    /**
     * Calculate total amount including services and discount
     */
    public function calculateTotalAmount()
    {
        // If price is not set, reset total
        if (!$this->price || $this->price <= 0) {
            $this->totalAmount = 0;
            return;
        }

        $basePrice = (float) $this->price;
        $additionalCharges = 0;

        // Calculate additional service charges
        foreach ($this->selectedServices as $serviceId) {
            $service = $this->additionalServicesList->firstWhere('id', $serviceId);
            if ($service) {
                $additionalCharges += $this->calculateServiceCharge($service, $basePrice);
            }
        }

        // Calculate total with discount
        $discount = min((float) $this->discountAmount, $basePrice + $additionalCharges);
        $this->totalAmount = max(0, $basePrice + $additionalCharges - $discount);
    }

    /**
     * Calculate individual service charge
     */
    private function calculateServiceCharge($service, $basePrice)
    {
        if ($service->charges_type === 'percentage') {
            return ($basePrice * $service->charge_value / 100);
        }
        return $service->charge_value;
    }

    /**
     * Validate passenger capacity
     */
    private function validatePassengerCapacity($vehicleCapacity)
    {
        $this->calculateTotalPassengers();
        $this->resetErrorBag(['no_of_adults', 'no_of_children', 'no_of_infants']);

        if ($this->total_passengers > $vehicleCapacity) {
            $this->addError('no_of_adults', "Total passengers ({$this->total_passengers}) exceed vehicle capacity ({$vehicleCapacity}).");
            return false;
        }

        if ($this->total_passengers < 1) {
            $this->addError('no_of_adults', 'At least one passenger is required.');
            return false;
        }

        return true;
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
     * Reset pickup related data
     */
    private function resetPickupData()
    {
        $this->pickup_location_name = '';
        $this->pickup_location_type = '';
        $this->pickup_city_id = '';
        $this->pickup_hotel_name = '';
        $this->clearFlightInfo();
        $this->resetDropoffAndVehicleData();
    }

    /**
     * Reset dropoff and vehicle data
     */
    private function resetDropoffAndVehicleData()
    {
        $this->resetDropoffData();
        $this->resetVehicleData();
    }

    /**
     * Reset dropoff data
     */
    private function resetDropoffData()
    {
        $this->dropoff_location_id = '';
        $this->dropoff_location_name = '';
        $this->dropoff_location_type = '';
        $this->dropoff_city_id = '';
        $this->dropoff_hotel_name = '';
    }

    /**
     * Reset vehicle data
     */
    private function resetVehicleData()
    {
        $this->vehicle_id = '';
        $this->vehicle_name = '';
        $this->price = '';
        $this->totalAmount = 0;
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
        // Validate all fields
        $this->validate();

        // Additional validations
        if (!$this->additionalValidations()) {
            return;
        }

        try {
            DB::beginTransaction();

            // Update booking
            $this->updateBooking();

            // Sync additional services
            $this->syncAdditionalServices();

            DB::commit();

            $this->dispatch('show-toast', type: 'success', message: 'Booking  updated successfully!');


            // session()->flash('message', "Booking #{$this->booking->id} updated successfully!");

            return redirect()->route('booking.index');
            
        } catch (\Exception $e) {
            DB::rollBack();

            // Log::error('Booking update failed', [
            //     'booking_id' => $this->bookingId,
            //     'error' => $e->getMessage(),
            //     'trace' => $e->getTraceAsString(),
            //     'data' => $this->all()
            // ]);

            $this->dispatch('show-toast', type: 'error', message: 'Failed to update booking. Please try again.');
            // session()->flash('error', 'Failed to update booking. Please try again.');
            $this->addError('update', 'An error occurred while updating the booking: ' . $e->getMessage());
        }
    }

    /**
     * Additional validations before update
     */
    private function additionalValidations()
    {
        $this->calculateTotalPassengers();

        // Validate minimum passengers
        if ($this->total_passengers < 1) {
            $this->addError('no_of_adults', 'At least one passenger is required.');
            return false;
        }

        // Validate vehicle capacity
        if ($this->vehicle_id) {
            $vehicle = CarDetails::find($this->vehicle_id);
            if ($vehicle && $this->total_passengers > $vehicle->seating_capacity) {
                $this->addError('no_of_adults', "Total passengers ({$this->total_passengers}) exceed vehicle capacity ({$vehicle->seating_capacity}).");
                return false;
            }
        }

        // Validate price is set
        if (!$this->price || $this->price <= 0) {
            $this->addError('price', 'Valid fare is required. Please select route and vehicle.');
            return false;
        }

        // Validate received payment doesn't exceed total
        if ($this->received_payment > $this->totalAmount) {
            $this->addError('received_payment', 'Received payment cannot exceed total amount.');
            return false;
        }

        return true;
    }

    /**
     * Update booking record
     */
    private function updateBooking()
    {
        // Format phone numbers
        $guestPhone = $this->formatPhoneNumber($this->guest_phone);
        $guestWhatsapp = $this->guest_whatsapp
            ? $this->formatPhoneNumber($this->guest_whatsapp)
            : $guestPhone;

        $this->booking->update([
            'guest_name' => trim($this->guest_name),
            'guest_phone' => $guestPhone,
            'guest_whatsapp' => $guestWhatsapp,
            'payment_type' => $this->payment_type,
            'pickup_location_id' => $this->pickup_location_id,
            'pickup_location_name' => $this->pickup_location_name,
            'pickup_hotel_name' => $this->pickup_hotel_name ?: null,
            'dropoff_location_id' => $this->dropoff_location_id,
            'dropoff_location_name' => $this->dropoff_location_name,
            'dropoff_hotel_name' => $this->dropoff_hotel_name ?: null,
            'vehicle_id' => $this->vehicle_id,
            'vehicle_name' => $this->vehicle_name,
            'no_of_children' => $this->no_of_children,
            'no_of_infants' => $this->no_of_infants,
            'no_of_adults' => $this->no_of_adults,
            'total_passengers' => $this->total_passengers,
            'pickup_date' => $this->pickup_date,
            'pickup_time' => $this->pickup_time,
            'airline_name' => $this->airline_name ?: null,
            'flight_number' => $this->flight_number ?: null,
            'flight_details' => $this->flight_details ?: null,
            'arrival_departure_date' => $this->arrival_departure_date ?: null,
            'arrival_departure_time' => $this->arrival_departure_time ?: null,
            'extra_information' => $this->extra_information ?: null,
            'booking_status' => $this->booking_status,
            'price' => $this->price,
            'total_amount' => $this->totalAmount,
            'discount_amount' => $this->discountAmount ?: 0,
            'recived_paymnet' => $this->received_payment ?: 0,
            'updated_by' => Auth::id(),
        ]);
    }

    /**
     * Sync additional services to booking
     */
    private function syncAdditionalServices()
    {
        if (empty($this->selectedServices)) {
            $this->booking->additionalServices()->detach();
            return;
        }

        $servicesData = [];
        
        foreach ($this->selectedServices as $serviceId) {
            $service = $this->additionalServicesList->firstWhere('id', $serviceId);
            if ($service) {
                $amount = $this->calculateServiceCharge($service, $this->price);
                $servicesData[$serviceId] = ['amount' => $amount];
            }
        }

        if (!empty($servicesData)) {
            $this->booking->additionalServices()->sync($servicesData);
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
        // Get active route fares with relationships
        $routeFares = RouteFares::where('status', 'active')
            ->where(function ($query) {
                $query->whereNull('start_date')
                    ->orWhere('start_date', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            })
            ->with(['pickupLocation', 'dropoffLocation', 'vehicle'])
            ->get();

        // Get unique IDs from route fares
        $pickupLocationIds = $routeFares->pluck('pickup_id')->unique();
        $dropoffLocationIds = $routeFares->pluck('dropoff_id')->unique();
        $vehicleIds = $routeFares->pluck('vehicle_id')->unique();

        // Get filtered data based on available routes
        $pickupLocations = PickUpLocation::whereIn('id', $pickupLocationIds)
            ->where('status', 'active')
            ->orderBy('pickup_location')
            ->get();

        $dropoffLocations = DropLocation::whereIn('id', $dropoffLocationIds)
            ->where('status', 'active')
            ->orderBy('drop_off_location')
            ->get();

        $vehicles = CarDetails::whereIn('id', $vehicleIds)
            ->orderBy('name')
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