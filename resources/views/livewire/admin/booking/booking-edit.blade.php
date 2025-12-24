<div>
    <div class="page-content">
        <div class="container-fluid">
            @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <livewire:admin.components.breadcrumbs title="Edit Booking" bredcrumb1="Booking Management"
                bredcrumb2="Edit Booking" />

            <div class="row">
                <div class="col-12">
                    <div class="card" x-data="bookingForm()">
                        <div class="card-body">
                            <form wire:submit.prevent="update">
                                <!-- Customer Information -->
                                <div class="row">
                                    <div class="col-12">
                                        <h4 class="card-title mb-4">Customer Information</h4>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="guest_name" class="form-label">Guest Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('guest_name') is-invalid @enderror"
                                                id="guest_name" wire:model.blur="guest_name"
                                                placeholder="Enter guest name">
                                            @error('guest_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="guest_phone" class="form-label">Phone Number <span
                                                    class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text">+</span>
                                                <input type="tel"
                                                    class="form-control @error('guest_phone') is-invalid @enderror"
                                                    id="guest_phone" wire:model.blur="guest_phone"
                                                    placeholder="Enter phone number" @blur="copyToWhatsappIfChecked()">
                                            </div>
                                            @error('guest_phone')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="guest_whatsapp" class="form-label">WhatsApp Number</label>
                                            <div class="input-group">
                                                <span class="input-group-text">+</span>
                                                <input type="tel"
                                                    class="form-control @error('guest_whatsapp') is-invalid @enderror"
                                                    id="guest_whatsapp" wire:model.blur="guest_whatsapp"
                                                    placeholder="Enter WhatsApp number" x-bind:disabled="copyWhatsapp">
                                            </div>
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="checkbox"
                                                    id="copy_contact_to_whatsapp" x-model="copyWhatsapp"
                                                    @change="copyToWhatsappIfChecked()">
                                                <label class="form-check-label" for="copy_contact_to_whatsapp">
                                                    Same as contact number
                                                </label>
                                            </div>
                                            @error('guest_whatsapp')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Route Information -->
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <h4 class="card-title mb-4">Route Information</h4>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="pickup_location_id" class="form-label">Pickup Location <span
                                                    class="text-danger">*</span></label>
                                            <select
                                                class="form-select @error('pickup_location_id') is-invalid @enderror"
                                                id="pickup_location_id" wire:model.live="pickup_location_id"
                                                @change="handlePickupChange($event)">
                                                <option value="">Select Pickup Location</option>
                                                @foreach ($pickupLocations as $location)
                                                    <option value="{{ $location->id }}"
                                                        data-type="{{ $location->type }}"
                                                        data-name="{{ $location->pickup_location }}"
                                                        {{ $location->id == $pickup_location_id ? 'selected' : '' }}>
                                                        {{ $location->pickup_location }}</option>
                                                @endforeach
                                            </select>
                                            @error('pickup_location_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="pickup_city_id" class="form-label">Pickup City</label>
                                            <select class="form-select @error('pickup_city_id') is-invalid @enderror"
                                                id="pickup_city_id" wire:model.live="pickup_city_id"
                                                @change="filterPickupHotels($event)">
                                                <option value="">Select City</option>
                                                @foreach ($cities as $city)
                                                    <option value="{{ $city->id }}" {{ $city->id == $pickup_city_id ? 'selected' : '' }}>
                                                        {{ $city->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('pickup_city_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6" x-show="showPickupHotel">
                                        <div class="mb-3">
                                            <label for="pickup_hotel_name" class="form-label">Pickup Hotel Name</label>
                                            <select class="form-select @error('pickup_hotel_name') is-invalid @enderror"
                                                id="pickup_hotel_name" wire:model.blur="pickup_hotel_name">
                                                <option value="">Select Hotel</option>
                                                <template x-for="hotel in filteredPickupHotels" :key="hotel.id">
                                                    <option :value="hotel.name" x-text="hotel.name" 
                                                        :selected="hotel.name == '{{ $pickup_hotel_name }}'"></option>
                                                </template>
                                            </select>
                                            <small class="text-muted">Select city first, then hotel will be available</small>
                                            @error('pickup_hotel_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="dropoff_location_id" class="form-label">Dropoff Location <span
                                                    class="text-danger">*</span></label>
                                            <select
                                                class="form-select @error('dropoff_location_id') is-invalid @enderror"
                                                id="dropoff_location_id" wire:model.live="dropoff_location_id"
                                                @change="handleDropoffChange($event)">
                                                <option value="">Select Dropoff Location</option>
                                                @foreach ($dropoffLocations as $location)
                                                    <option value="{{ $location->id }}"
                                                        data-type="{{ $location->type }}"
                                                        data-name="{{ $location->drop_off_location }}"
                                                        {{ $location->id == $dropoff_location_id ? 'selected' : '' }}>
                                                        {{ $location->drop_off_location }}</option>
                                                @endforeach
                                            </select>
                                            @error('dropoff_location_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="dropoff_city_id" class="form-label">Dropoff City</label>
                                            <select class="form-select @error('dropoff_city_id') is-invalid @enderror"
                                                id="dropoff_city_id" wire:model.live="dropoff_city_id"
                                                @change="filterDropoffHotels($event)">
                                                <option value="">Select City</option>
                                                @foreach ($cities as $city)
                                                    <option value="{{ $city->id }}" {{ $city->id == $dropoff_city_id ? 'selected' : '' }}>{{ $city->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('dropoff_city_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6" x-show="showDropoffHotel">
                                        <div class="mb-3">
                                            <label for="dropoff_hotel_name" class="form-label">Dropoff Hotel Name</label>
                                            <select
                                                class="form-select @error('dropoff_hotel_name') is-invalid @enderror"
                                                id="dropoff_hotel_name" wire:model.blur="dropoff_hotel_name">
                                                <option value="">Select Hotel</option>
                                                <template x-for="hotel in filteredDropoffHotels" :key="hotel.id">
                                                    <option :value="hotel.name" x-text="hotel.name" 
                                                        :selected="hotel.name == '{{ $dropoff_hotel_name }}'"></option>
                                                </template>
                                            </select>
                                            <small class="text-muted">Select city first, then hotel will be available</small>
                                            @error('dropoff_hotel_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Vehicle Information -->
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <h4 class="card-title mb-4">Vehicle Information</h4>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="vehicle_id" class="form-label">Vehicle <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select @error('vehicle_id') is-invalid @enderror"
                                                id="vehicle_id" wire:model.live="vehicle_id"
                                                @change="handleVehicleChange($event)">
                                                <option value="">Select Vehicle</option>
                                                <template x-for="vehicle in filteredVehicles" :key="vehicle.id">
                                                    <option :value="vehicle.id"
                                                        :data-capacity="vehicle.seating_capacity"
                                                        :data-name="`${vehicle.name} - ${vehicle.model_variant}`"
                                                        :selected="vehicle.id == {{ $vehicle_id }}"
                                                        x-text="`${vehicle.name} - ${vehicle.model_variant} (Seats: ${vehicle.seating_capacity}, Bags: ${vehicle.bag_capacity})`">
                                                    </option>
                                                </template>
                                            </select>
                                            <small class="text-muted" x-show="filteredVehicles.length === 0" style="color: red !important;">
                                                No vehicles available for this route
                                            </small>
                                            <small class="text-muted" x-show="filteredVehicles.length > 0" x-text="`${filteredVehicles.length} vehicle(s) available`"></small>
                                            @error('vehicle_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="price" class="form-label">Price (SAR) <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" step="0.01"
                                                class="form-control @error('price') is-invalid @enderror"
                                                id="price" wire:model.blur="price" placeholder="Enter price"
                                                x-bind:value="calculatedPrice" readonly>
                                            @error('price')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Passenger Information -->
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <h4 class="card-title mb-4">Passenger Information</h4>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="no_of_adults" class="form-label">Adults <span
                                                    class="text-danger">*</span></label>
                                            <input type="number"
                                                class="form-control @error('no_of_adults') is-invalid @enderror"
                                                id="no_of_adults" wire:model.live="no_of_adults" min="1"
                                                @input="validateCapacity()">
                                            @error('no_of_adults')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="no_of_children" class="form-label">Children</label>
                                            <input type="number"
                                                class="form-control @error('no_of_children') is-invalid @enderror"
                                                id="no_of_children" wire:model.live="no_of_children" min="0"
                                                @input="validateCapacity()">
                                            @error('no_of_children')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="no_of_infants" class="form-label">Infants</label>
                                            <input type="number"
                                                class="form-control @error('no_of_infants') is-invalid @enderror"
                                                id="no_of_infants" wire:model.live="no_of_infants" min="0">
                                            @error('no_of_infants')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Total Passengers</label>
                                            <div class="form-control bg-light" x-text="totalPassengers"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Schedule Information -->
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <h4 class="card-title mb-4">Schedule Information</h4>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="pickup_date" class="form-label">Pickup Date <span
                                                    class="text-danger">*</span></label>
                                            <input type="date"
                                                class="form-control @error('pickup_date') is-invalid @enderror"
                                                id="pickup_date" min="{{ now()->format('Y-m-d') }}"
                                                wire:model.blur="pickup_date">
                                            @error('pickup_date')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="pickup_time" class="form-label">Pickup Time <span
                                                    class="text-danger">*</span></label>
                                            <input type="time"
                                                class="form-control @error('pickup_time') is-invalid @enderror"
                                                id="pickup_time" wire:model.blur="pickup_time">
                                            @error('pickup_time')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Flight Information -->
                                <div class="row mt-4" x-show="showFlightSection">
                                    <div class="col-12">
                                        <h4 class="card-title mb-4">Flight Information (Optional)</h4>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="airline_name" class="form-label">Airline Name</label>
                                            <input type="text"
                                                class="form-control @error('airline_name') is-invalid @enderror"
                                                id="airline_name" wire:model.blur="airline_name"
                                                placeholder="Enter airline name">
                                            @error('airline_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="flight_number" class="form-label">Flight Number</label>
                                            <input type="text"
                                                class="form-control @error('flight_number') is-invalid @enderror"
                                                id="flight_number" wire:model.blur="flight_number"
                                                placeholder="Enter flight number">
                                            @error('flight_number')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="arrival_departure_date" class="form-label">Arrival/Departure
                                                Date</label>
                                            <input type="date"
                                                class="form-control @error('arrival_departure_date') is-invalid @enderror"
                                                min="{{ now()->format('Y-m-d') }}" id="arrival_departure_date"
                                                wire:model.blur="arrival_departure_date">
                                            @error('arrival_departure_date')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="arrival_departure_time" class="form-label">Arrival/Departure
                                                Time</label>
                                            <input type="time"
                                                class="form-control @error('arrival_departure_time') is-invalid @enderror"
                                                id="arrival_departure_time" wire:model.blur="arrival_departure_time">
                                            @error('arrival_departure_time')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="flight_details" class="form-label">Flight Details</label>
                                            <textarea class="form-control @error('flight_details') is-invalid @enderror" id="flight_details"
                                                wire:model.blur="flight_details" rows="2" placeholder="Enter flight details"></textarea>
                                            @error('flight_details')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Additional Information -->
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <h4 class="card-title mb-4">Additional Information</h4>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="booking_status" class="form-label">Booking Status <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select @error('booking_status') is-invalid @enderror"
                                                id="booking_status" wire:model.blur="booking_status">
                                                <option value="pending" {{ $booking_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="confirmed" {{ $booking_status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                <option value="cancelled" {{ $booking_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                <option value="completed" {{ $booking_status == 'completed' ? 'selected' : '' }}>Completed</option>
                                            </select>
                                            @error('booking_status')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="recived_paymnet" class="form-label">Received Payment
                                                (SAR)</label>
                                            <input type="number" step="0.01"
                                                class="form-control @error('recived_paymnet') is-invalid @enderror"
                                                id="recived_paymnet" wire:model.blur="recived_paymnet"
                                                placeholder="Enter received payment">
                                            @error('recived_paymnet')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="extra_information" class="form-label">Extra
                                                Information</label>
                                            <textarea class="form-control @error('extra_information') is-invalid @enderror" id="extra_information"
                                                wire:model.blur="extra_information" rows="3" placeholder="Enter any additional information"></textarea>
                                            @error('extra_information')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Actions -->
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('booking.index') }}" class="btn btn-secondary">
                                                <i class="fas fa-times me-2"></i>Cancel
                                            </a>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save me-2"></i>Update Booking
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function bookingForm() {
    return {
        routeFares: @json($routeFares),
        vehicles: @json($vehicles),
        hotels: @json($hotels),
        pickupLocations: @json($pickupLocations),
        dropoffLocations: @json($dropoffLocations),

        copyWhatsapp: false,
        showPickupHotel: false,
        showDropoffHotel: false,
        showFlightSection: false,
        pickupLocationType: '',
        dropoffLocationType: '',
        vehicleCapacity: 4,

        filteredPickupHotels: [],
        filteredDropoffHotels: [],
        filteredVehicles: [],
        calculatedPrice: '',

        init() {
            console.log('Alpine initialized');
            this.filteredPickupHotels = this.hotels;
            this.filteredDropoffHotels = this.hotels;
            this.filteredVehicles = this.vehicles;
            this.loadExistingData();
            this.$watch('copyWhatsapp', value => {
                if (value) this.copyToWhatsappIfChecked();
            });
        },

        loadExistingData() {
            this.pickupLocationType = '{{ $pickup_location_type }}' || '';
            this.dropoffLocationType = '{{ $dropoff_location_type }}' || '';
            this.showPickupHotel = (this.pickupLocationType === 'Hotel');
            this.showDropoffHotel = (this.dropoffLocationType === 'Hotel');
            this.showFlightSection = (this.pickupLocationType === 'Airport');
            this.calculatedPrice = '{{ $price }}' || '';

            const phone = '{{ $guest_phone }}';
            const whatsapp = '{{ $guest_whatsapp }}';
            if (phone && whatsapp && phone === whatsapp) {
                this.copyWhatsapp = true;
            }

            const currentVehicleId = parseInt('{{ $vehicle_id }}');
            if (currentVehicleId) {
                const vehicle = this.vehicles.find(v => v.id === currentVehicleId);
                if (vehicle) this.vehicleCapacity = parseInt(vehicle.seating_capacity);
            }

            const pickupCityId = '{{ $pickup_city_id }}';
            const dropoffCityId = '{{ $dropoff_city_id }}';
            if (pickupCityId) this.filteredPickupHotels = this.hotels.filter(h => h.city_id == pickupCityId);
            if (dropoffCityId) this.filteredDropoffHotels = this.hotels.filter(h => h.city_id == dropoffCityId);

            this.filterVehiclesByRoute();
        },

        get totalPassengers() {
            const adults = parseInt(this.$wire.no_of_adults) || 0;
            const children = parseInt(this.$wire.no_of_children) || 0;
            const infants = parseInt(this.$wire.no_of_infants) || 0;
            return adults + children + infants;
        },

        copyToWhatsappIfChecked() {
            if (this.copyWhatsapp) this.$wire.guest_whatsapp = this.$wire.guest_phone;
        },

        handlePickupChange(event) {
            const option = event.target.selectedOptions[0];
            const type = option?.dataset.type || '';
            const name = option?.dataset.name || '';

            this.pickupLocationType = type;
            this.showPickupHotel = (type === 'Hotel');
            this.showFlightSection = (type === 'Airport');

            this.$wire.pickup_location_type = type;
            this.$wire.pickup_location_name = name;

            if (type !== 'Hotel') {
                this.$wire.pickup_hotel_name = '';
                this.$wire.pickup_city_id = '';
            }

            if (type !== 'Airport') {
                this.$wire.airline_name = '';
                this.$wire.flight_number = '';
                this.$wire.arrival_departure_date = '';
                this.$wire.arrival_departure_time = '';
                this.$wire.flight_details = '';
            }

            this.filterVehiclesByRoute();
            this.calculatePrice();
        },

        handleDropoffChange(event) {
            const option = event.target.selectedOptions[0];
            const type = option?.dataset.type || '';
            const name = option?.dataset.name || '';

            this.dropoffLocationType = type;
            this.showDropoffHotel = (type === 'Hotel');

            this.$wire.dropoff_location_type = type;
            this.$wire.dropoff_location_name = name;

            if (type !== 'Hotel') {
                this.$wire.dropoff_hotel_name = '';
                this.$wire.dropoff_city_id = '';
            }

            this.filterVehiclesByRoute();
            this.calculatePrice();
        },

        handleVehicleChange(event) {
            const option = event.target.selectedOptions[0];
            const capacity = parseInt(option?.dataset.capacity) || 4;
            const name = option?.dataset.name || '';

            this.vehicleCapacity = capacity;
            this.$wire.vehicle_name = name;
            this.$wire.vehicle_id = option.value;

            this.validateCapacity();
            this.calculatePrice();
        },

        filterPickupHotels(event) {
            const cityId = event.target.value;
            this.filteredPickupHotels = cityId 
                ? this.hotels.filter(h => h.city_id == cityId) 
                : this.hotels;
            
            if (this.$wire.pickup_hotel_name) {
                const hotelExists = this.filteredPickupHotels.some(h => h.name == this.$wire.pickup_hotel_name);
                if (!hotelExists) this.$wire.pickup_hotel_name = '';
            }
            this.$wire.pickup_city_id = cityId;
        },

        filterDropoffHotels(event) {
            const cityId = event.target.value;
            this.filteredDropoffHotels = cityId 
                ? this.hotels.filter(h => h.city_id == cityId) 
                : this.hotels;
            
            if (this.$wire.dropoff_hotel_name) {
                const hotelExists = this.filteredDropoffHotels.some(h => h.name == this.$wire.dropoff_hotel_name);
                if (!hotelExists) this.$wire.dropoff_hotel_name = '';
            }
            this.$wire.dropoff_city_id = cityId;
        },

        filterVehiclesByRoute() {
            const pickupId = this.$wire.pickup_location_id;
            const dropoffId = this.$wire.dropoff_location_id;

            if (!pickupId || !dropoffId) {
                this.filteredVehicles = this.vehicles;
                return;
            }

            const validVehicles = new Set();
            this.routeFares.forEach(fare => {
                if (fare.pickup_id == pickupId && fare.dropoff_id == dropoffId) {
                    validVehicles.add(fare.vehicle_id);
                }
            });

            this.filteredVehicles = this.vehicles.filter(v => validVehicles.has(v.id));

            const currentVehicleId = parseInt(this.$wire.vehicle_id);
            if (currentVehicleId && !validVehicles.has(currentVehicleId)) {
                this.$wire.vehicle_id = '';
                this.$wire.vehicle_name = '';
                this.calculatedPrice = '';
                this.$wire.price = '';
                console.log('Current vehicle not available for this route - cleared');
            }

            if (this.filteredVehicles.length === 1) {
                const vehicle = this.filteredVehicles[0];
                this.$wire.vehicle_id = vehicle.id;
                this.vehicleCapacity = vehicle.seating_capacity;
                this.$wire.vehicle_name = `${vehicle.name} - ${vehicle.model_variant}`;
                this.calculatePrice();
            }

            console.log('Filtered vehicles:', this.filteredVehicles.length);
        },

        calculatePrice() {
            const pickupId = this.$wire.pickup_location_id;
            const dropoffId = this.$wire.dropoff_location_id;
            const vehicleId = this.$wire.vehicle_id;

            if (!pickupId || !dropoffId || !vehicleId) {
                this.calculatedPrice = '';
                this.$wire.price = '';
                return;
            }

            const fare = this.routeFares.find(f =>
                f.pickup_id == pickupId &&
                f.dropoff_id == dropoffId &&
                f.vehicle_id == vehicleId
            );

            if (fare) {
                this.calculatedPrice = fare.amount;
                this.$wire.price = fare.amount;
            } else {
                this.calculatedPrice = '';
                this.$wire.price = '';
            }
        },

        validateCapacity() {
            const total = this.totalPassengers;
            if (total > this.vehicleCapacity) {
                alert(`Warning: Total passengers (${total}) exceed vehicle capacity (${this.vehicleCapacity})`);
                return false;
            }
            return true;
        }
    };
}
</script>