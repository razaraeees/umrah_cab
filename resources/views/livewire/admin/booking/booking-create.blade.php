<div>
    <div class="page-content">
        <div class="container-fluid">
            @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <livewire:admin.components.breadcrumbs title="Create Booking" bredcrumb1="Booking Management"
                bredcrumb2="Create Booking" />

            <div class="row">
                <div class="col-12">
                    <div class="card" x-data="bookingForm()">
                        <div class="card-body">
                            <form wire:submit.prevent="save">
                                <div class="row">
                                    <!-- Customer Information -->
                                    <div class="col-12">
                                        <h4 class="card-title mb-4">Customer Information</h4>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="guest_name" class="form-label">Guest Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('guest_name') is-invalid @enderror"
                                                id="guest_name" wire:model="guest_name" placeholder="Enter guest name">
                                            @error('guest_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="guest_phone" class="form-label">Phone Number <span
                                                    class="text-danger">*</span></label>
                                            <input type="tel"
                                                class="form-control @error('guest_phone') is-invalid @enderror"
                                                id="guest_phone" wire:model="guest_phone"
                                                placeholder="Enter phone number without +">
                                            @error('guest_phone')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="guest_whatsapp" class="form-label">WhatsApp Number</label>
                                            <input type="tel"
                                                class="form-control @error('guest_whatsapp') is-invalid @enderror"
                                                id="guest_whatsapp" wire:model="guest_whatsapp"
                                                placeholder="Enter WhatsApp number">
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="checkbox"
                                                    id="copy_contact_to_whatsapp" x-model="copyContactToWhatsapp">
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
                                                id="pickup_location_id" wire:model="pickup_location_id"
                                                @change="toggleHotelFields('pickup_location_id', 'pickup_hotel_dropdown', 'pickup_hotel_text', 'pickup_city_id')">
                                                <option value="">Select Pickup Location</option>
                                                @foreach ($pickupLocations as $location)
                                                    <option value="{{ $location->id }}"
                                                        data-type="{{ $location->type }}">
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
                                                id="pickup_city_id" wire:model="pickup_city_id"
                                                @change="toggleHotelFields('pickup_location_id', 'pickup_hotel_dropdown', 'pickup_hotel_text', 'pickup_city_id')">
                                                <option value="">Select City</option>
                                                @foreach ($cities as $city)
                                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('pickup_city_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="pickup_hotel_name" class="form-label">Pickup Hotel Name</label>

                                            <!-- Hotel Dropdown (shown when location type is hotel) -->
                                            <select class="form-select @error('pickup_hotel_name') is-invalid @enderror"
                                                id="pickup_hotel_dropdown" wire:model="pickup_hotel_name"
                                                style="display: none;">
                                                <option value="">Select Hotel</option>
                                                @foreach ($hotels as $hotel)
                                                    <option value="{{ $hotel->name }}"
                                                        data-city-id="{{ $hotel->city_id }}">{{ $hotel->name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <!-- Hotel Text Input (shown when location type is not hotel or fallback) -->
                                            <input type="text"
                                                class="form-control @error('pickup_hotel_name') is-invalid @enderror"
                                                id="pickup_hotel_text" wire:model="pickup_hotel_name"
                                                placeholder="Hotel name only for hotel locations" disabled>

                                            <small class="text-muted">Select city first, then hotel will be available
                                                when pickup location type is 'Hotel'</small>
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
                                                id="dropoff_location_id" wire:model="dropoff_location_id"
                                                @change="toggleHotelFields('dropoff_location_id', 'dropoff_hotel_dropdown', 'dropoff_hotel_text', 'dropoff_city_id')">
                                                <option value="">Select Dropoff Location</option>
                                                @foreach ($dropoffLocations as $location)
                                                    <option value="{{ $location->id }}"
                                                        data-type="{{ $location->type }}">
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
                                                id="dropoff_city_id" wire:model="dropoff_city_id"
                                                @change="toggleHotelFields('dropoff_location_id', 'dropoff_hotel_dropdown', 'dropoff_hotel_text', 'dropoff_city_id')">
                                                <option value="">Select City</option>
                                                @foreach ($cities as $city)
                                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('dropoff_city_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="dropoff_hotel_name" class="form-label">Dropoff Hotel
                                                Name</label>

                                            <!-- Hotel Dropdown (shown when location type is hotel) -->
                                            <select
                                                class="form-select @error('dropoff_hotel_name') is-invalid @enderror"
                                                id="dropoff_hotel_dropdown" wire:model="dropoff_hotel_name"
                                                style="display: none;">
                                                <option value="">Select Hotel</option>
                                                @foreach ($hotels as $hotel)
                                                    <option value="{{ $hotel->name }}"
                                                        data-city-id="{{ $hotel->city_id }}">{{ $hotel->name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <!-- Hotel Text Input (shown when location type is not hotel or fallback) -->
                                            <input type="text"
                                                class="form-control @error('dropoff_hotel_name') is-invalid @enderror"
                                                id="dropoff_hotel_text" wire:model="dropoff_hotel_name"
                                                placeholder="Hotel name only for hotel locations" disabled>

                                            <small class="text-muted">Select city first, then hotel will be available
                                                when dropoff location type is 'Hotel'</small>
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
                                                id="vehicle_id" wire:model="vehicle_id"
                                                @change="updateVehicleCapacity()">
                                                <option value="">Select Vehicle</option>
                                                @foreach ($vehicles as $vehicle)
                                                    <option value="{{ $vehicle->id }}">{{ $vehicle->name }} -
                                                        {{ $vehicle->model_variant }} (Seats:
                                                        {{ $vehicle->seating_capacity }}, Bags:
                                                        {{ $vehicle->bag_capacity }})</option>
                                                @endforeach
                                            </select>
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
                                                id="price" wire:model="price" placeholder="Enter price">
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
                                                id="no_of_adults" wire:model="no_of_adults" min="1"
                                                @input="updateTotalPassengers()">
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
                                                id="no_of_children" wire:model="no_of_children" min="0"
                                                @input="updateTotalPassengers()">
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
                                                id="no_of_infants" wire:model="no_of_infants" min="0"
                                                @input="updateTotalPassengers()">
                                            @error('no_of_infants')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Total Passengers</label>
                                            <div class="form-control bg-light">
                                                {{ $total_passengers ?? 0 }}
                                            </div>
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
                                                id="pickup_date" wire:model="pickup_date">
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
                                                id="pickup_time" wire:model="pickup_time">
                                            @error('pickup_time')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Flight Information -->
                                <div class="row mt-4" id="flight_information_section">
                                    <div class="col-12">
                                        <h4 class="card-title mb-4">Flight Information (Optional)</h4>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="airline_name" class="form-label">Airline Name</label>
                                            <input type="text"
                                                class="form-control @error('airline_name') is-invalid @enderror"
                                                id="airline_name" wire:model="airline_name"
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
                                                id="flight_number" wire:model="flight_number"
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
                                                id="arrival_departure_date" wire:model="arrival_departure_date">
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
                                                id="arrival_departure_time" wire:model="arrival_departure_time">
                                            @error('arrival_departure_time')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="flight_details" class="form-label">Flight Details</label>
                                            <textarea class="form-control @error('flight_details') is-invalid @enderror" id="flight_details"
                                                wire:model="flight_details" rows="2" placeholder="Enter flight details"></textarea>
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
                                                id="booking_status" wire:model="booking_status">
                                                <option value="pending">Pending</option>
                                                <option value="confirmed">Confirmed</option>
                                                <option value="cancelled">Cancelled</option>
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
                                                id="recived_paymnet" wire:model="recived_paymnet"
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
                                                wire:model="extra_information" rows="3" placeholder="Enter any additional information"></textarea>
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
                                                <i class="fas fa-save me-2"></i>Save Booking
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
            pickupLocationType: '',
            dropoffLocationType: '',
            maxCapacity: 4,

            init() {
                this.$wire.on('dataUpdated', () => {
                    this.updatePickupLocationType();
                    this.updateDropoffLocationType();
                    this.updateVehicleCapacity();
                });
            },

            updateVehicleCapacity() {
                const vehicleSelect = document.getElementById('vehicle_id');
                if (vehicleSelect && vehicleSelect.value) {
                    const selectedVehicle = this.vehicles.find(v => v.id == vehicleSelect.value);
                    if (selectedVehicle) {
                        this.maxCapacity = selectedVehicle.seating_capacity || 4;
                    }
                }
                this.$nextTick(() => {
                    this.calculatePrice();
                });
            },

            calculatePrice() {
                const vehicleId = document.getElementById('vehicle_id')?.value;
                const pickupId = document.getElementById('pickup_location_id')?.value;
                const dropoffId = document.getElementById('dropoff_location_id')?.value;
                const priceInput = document.getElementById('price');

                if (vehicleId && pickupId && dropoffId && this.routeFares && priceInput) {
                    const fare = this.routeFares.find(f =>
                        f.vehicle_id == vehicleId &&
                        f.pickup_id == pickupId &&
                        f.dropoff_id == dropoffId
                    );

                    if (fare) {
                        priceInput.value = fare.amount;
                        this.$wire.price = fare.amount;
                    }
                }
            },

            copyContactToWhatsapp() {
                const contactPhone = document.getElementById('guest_phone')?.value;
                const whatsappCheckbox = document.getElementById('copy_contact_to_whatsapp');
                const whatsappInput = document.getElementById('guest_whatsapp');

                if (whatsappCheckbox?.checked && contactPhone) {
                    whatsappInput.value = contactPhone;
                    this.$wire.guest_whatsapp = contactPhone;
                } else if (!whatsappCheckbox?.checked) {
                    whatsappInput.value = '';
                    this.$wire.guest_whatsapp = '';
                }
            },

            validatePassengerCapacity() {
                const adultsInput = document.getElementById('no_of_adults');
                const childrenInput = document.getElementById('no_of_children');
                const infantsInput = document.getElementById('no_of_infants');
                const totalPassengersElement = document.querySelector('.bg-light');

                const adults = parseInt(adultsInput?.value) || 0;
                const children = parseInt(childrenInput?.value) || 0;
                const infants = parseInt(infantsInput?.value) || 0;
                const total = adults + children;

                if (totalPassengersElement) {
                    totalPassengersElement.textContent = adults + children + infants;
                }

                this.$wire.no_of_adults = adults;
                this.$wire.no_of_children = children;
                this.$wire.no_of_infants = infants;
                this.$wire.total_passengers = adults + children + infants;

                if (total > this.maxCapacity) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Capacity Exceeded!',
                        text: `Maximum seating capacity is ${this.maxCapacity} passengers. You have entered ${total} adults + children (infants not counted).`,
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#d33'
                    });

                    const event = window.event;
                    const target = event?.target;

                    if (target?.id === 'no_of_adults') {
                        adultsInput.value = this.maxCapacity;
                        this.$wire.no_of_adults = this.maxCapacity;
                    } else if (target?.id === 'no_of_children') {
                        const maxChildren = Math.max(0, this.maxCapacity - adults);
                        childrenInput.value = maxChildren;
                        this.$wire.no_of_children = maxChildren;
                    }
                }
            },

            updatePickupLocationType() {
                const select = document.getElementById('pickup_location_id');
                if (select) {
                    const selectedOption = select.options[select.selectedIndex];
                    const locationType = selectedOption.getAttribute('data-type') || '';
                    this.pickupLocationType = locationType;

                    this.$wire.pickup_location_type = locationType;

                    if (select.value) {
                        this.$wire.pickup_location_name = selectedOption.textContent.trim();
                    }

                    this.toggleFlightSection();
                    this.filterDropoffLocations();
                }
            },

            updateDropoffLocationType() {
                const select = document.getElementById('dropoff_location_id');
                if (select) {
                    const selectedOption = select.options[select.selectedIndex];
                    const locationType = selectedOption.getAttribute('data-type') || '';
                    this.dropoffLocationType = locationType;

                    this.$wire.dropoff_location_type = locationType;

                    if (select.value) {
                        this.$wire.dropoff_location_name = selectedOption.textContent.trim();
                    }

                    this.filterVehicles();
                }
            },

            toggleHotelFields(selectId, dropdownId, textId, cityId) {
                const select = document.getElementById(selectId);
                const dropdown = document.getElementById(dropdownId);
                const textInput = document.getElementById(textId);
                const citySelect = document.getElementById(cityId);

                if (!select || !dropdown || !textInput) return;

                const selectedOption = select.options[select.selectedIndex];
                const locationType = selectedOption.getAttribute('data-type');

                if (locationType === 'Hotel') {
                    dropdown.style.display = 'block';
                    textInput.style.display = 'none';
                    textInput.disabled = true;
                    dropdown.disabled = false;

                    if (citySelect) {
                        this.filterHotelsByCity(dropdown, citySelect);
                    }
                } else {
                    dropdown.style.display = 'none';
                    textInput.style.display = 'block';
                    textInput.disabled = true;
                    dropdown.disabled = true;
                    dropdown.value = '';
                    textInput.value = '';

                    if (selectId === 'pickup_location_id') {
                        this.$wire.pickup_hotel_name = '';
                    } else {
                        this.$wire.dropoff_hotel_name = '';
                    }
                }
            },

            filterHotelsByCity(hotelDropdown, citySelect) {
                const selectedCityId = citySelect.value;
                const options = hotelDropdown.querySelectorAll('option');

                hotelDropdown.value = '';

                options.forEach(option => {
                    if (option.value === '') {
                        option.style.display = 'block';
                    } else {
                        const hotelCityId = option.getAttribute('data-city-id');
                        option.style.display = (selectedCityId === '' || hotelCityId === selectedCityId) ?
                            'block' : 'none';
                    }
                });
            },

            toggleFlightSection() {
                const flightSection = document.getElementById('flight_information_section');
                if (flightSection) {
                    if (this.pickupLocationType === 'Airport') {
                        flightSection.style.display = 'block';
                    } else {
                        flightSection.style.display = 'none';
                        const fields = ['airline_name', 'flight_number', 'arrival_departure_date',
                            'arrival_departure_time', 'flight_details'
                        ];
                        fields.forEach(field => {
                            const input = document.getElementById(field);
                            if (input) {
                                input.value = '';
                                this.$wire[field] = '';
                            }
                        });
                    }
                }
            },

            filterDropoffLocations() {
                const pickupSelect = document.getElementById('pickup_location_id');
                const dropoffSelect = document.getElementById('dropoff_location_id');
                const vehicleSelect = document.getElementById('vehicle_id');

                if (!pickupSelect || !dropoffSelect || !vehicleSelect) return;

                const pickupId = pickupSelect.value;

                if (!pickupId) {
                    const dropoffOptions = dropoffSelect.querySelectorAll('option');
                    dropoffOptions.forEach(option => {
                        option.style.display = 'block';
                    });
                    return;
                }

                const validDropoffs = new Set();
                const validVehicles = new Set();

                this.routeFares.forEach(fare => {
                    if (fare.pickup_id == pickupId) {
                        validDropoffs.add(fare.dropoff_id);
                        validVehicles.add(fare.vehicle_id);
                    }
                });

                const dropoffOptions = dropoffSelect.querySelectorAll('option');
                dropoffOptions.forEach(option => {
                    if (option.value === '') {
                        option.style.display = 'block';
                    } else {
                        option.style.display = validDropoffs.has(parseInt(option.value)) ? 'block' : 'none';
                    }
                });

                const vehicleOptions = vehicleSelect.querySelectorAll('option');
                vehicleOptions.forEach(option => {
                    if (option.value === '') {
                        option.style.display = 'block';
                    } else {
                        option.style.display = validVehicles.has(parseInt(option.value)) ? 'block' : 'none';
                    }
                });

                if (dropoffSelect.value && !validDropoffs.has(parseInt(dropoffSelect.value))) {
                    dropoffSelect.value = '';
                    this.$wire.dropoff_location_id = '';
                    this.$wire.dropoff_location_name = '';
                }

                if (vehicleSelect.value && !validVehicles.has(parseInt(vehicleSelect.value))) {
                    vehicleSelect.value = '';
                    this.$wire.vehicle_id = '';
                    this.$wire.vehicle_name = '';
                    this.$wire.price = '';
                    document.getElementById('price').value = '';
                }
            },

            filterVehicles() {
                const pickupSelect = document.getElementById('pickup_location_id');
                const dropoffSelect = document.getElementById('dropoff_location_id');
                const vehicleSelect = document.getElementById('vehicle_id');

                if (!pickupSelect || !dropoffSelect || !vehicleSelect) return;

                const pickupId = pickupSelect.value;
                const dropoffId = dropoffSelect.value;

                if (!pickupId || !dropoffId) return;

                const validVehicles = new Set();

                this.routeFares.forEach(fare => {
                    if (fare.pickup_id == pickupId && fare.dropoff_id == dropoffId) {
                        validVehicles.add(fare.vehicle_id);
                    }
                });

                const vehicleOptions = vehicleSelect.querySelectorAll('option');
                vehicleOptions.forEach(option => {
                    if (option.value === '') {
                        option.style.display = 'block';
                    } else {
                        option.style.display = validVehicles.has(parseInt(option.value)) ? 'block' : 'none';
                    }
                });

                if (vehicleSelect.value && !validVehicles.has(parseInt(vehicleSelect.value))) {
                    vehicleSelect.value = '';
                    this.$wire.vehicle_id = '';
                    this.$wire.vehicle_name = '';
                    this.$wire.price = '';
                    document.getElementById('price').value = '';
                }

                if (validVehicles.size === 1) {
                    const vehicleId = Array.from(validVehicles)[0];
                    vehicleSelect.value = vehicleId;
                    this.$wire.vehicle_id = vehicleId;
                    this.updateVehicleCapacity();
                }
            },

            // ✅ NEW FUNCTION - Submit se pehle sab sync karo
            submitForm() {
                // Sync all form values to Livewire before submission
                this.$wire.guest_name = document.getElementById('guest_name')?.value || '';
                this.$wire.guest_phone = document.getElementById('guest_phone')?.value || '';
                this.$wire.guest_whatsapp = document.getElementById('guest_whatsapp')?.value || '';

                this.$wire.pickup_location_id = document.getElementById('pickup_location_id')?.value || '';
                this.$wire.pickup_city_id = document.getElementById('pickup_city_id')?.value || '';

                const pickupHotelDropdown = document.getElementById('pickup_hotel_dropdown');
                const pickupHotelText = document.getElementById('pickup_hotel_text');
                if (pickupHotelDropdown.style.display !== 'none') {
                    this.$wire.pickup_hotel_name = pickupHotelDropdown.value || '';
                } else {
                    this.$wire.pickup_hotel_name = pickupHotelText.value || '';
                }

                this.$wire.dropoff_location_id = document.getElementById('dropoff_location_id')?.value || '';
                this.$wire.dropoff_city_id = document.getElementById('dropoff_city_id')?.value || '';

                const dropoffHotelDropdown = document.getElementById('dropoff_hotel_dropdown');
                const dropoffHotelText = document.getElementById('dropoff_hotel_text');
                if (dropoffHotelDropdown.style.display !== 'none') {
                    this.$wire.dropoff_hotel_name = dropoffHotelDropdown.value || '';
                } else {
                    this.$wire.dropoff_hotel_name = dropoffHotelText.value || '';
                }

                this.$wire.vehicle_id = document.getElementById('vehicle_id')?.value || '';
                this.$wire.price = document.getElementById('price')?.value || '';

                this.$wire.no_of_adults = parseInt(document.getElementById('no_of_adults')?.value) || 1;
                this.$wire.no_of_children = parseInt(document.getElementById('no_of_children')?.value) || 0;
                this.$wire.no_of_infants = parseInt(document.getElementById('no_of_infants')?.value) || 0;

                this.$wire.pickup_date = document.getElementById('pickup_date')?.value || '';
                this.$wire.pickup_time = document.getElementById('pickup_time')?.value || '';

                this.$wire.airline_name = document.getElementById('airline_name')?.value || '';
                this.$wire.flight_number = document.getElementById('flight_number')?.value || '';
                this.$wire.flight_details = document.getElementById('flight_details')?.value || '';
                this.$wire.arrival_departure_date = document.getElementById('arrival_departure_date')?.value || '';
                this.$wire.arrival_departure_time = document.getElementById('arrival_departure_time')?.value || '';

                this.$wire.booking_status = document.getElementById('booking_status')?.value || 'pending';
                this.$wire.recived_paymnet = document.getElementById('recived_paymnet')?.value || '';
                this.$wire.extra_information = document.getElementById('extra_information')?.value || '';

                // Now submit the form
                this.$wire.save();
            }
        }
    }
</script>
