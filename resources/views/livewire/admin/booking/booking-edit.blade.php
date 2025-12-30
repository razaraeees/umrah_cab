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

                                    <div class="col-md-3">
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

                                    <div class="col-md-3">
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

                                    <div class="col-md-3">
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

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="payment_type" class="form-label">Payment Type <span
                                                    class="text-danger">*</span></label>
                                            <select
                                                class="form-select @error('payment_type') is-invalid @enderror"
                                                id="payment_type" wire:model.live="payment_type">
                                                <option value="credit">Credit</option>
                                                <option value="cash">Cash</option>
                                            </select>
                                            @error('payment_type')
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
                                            <label for="price" class="form-label">Base Price (SAR) <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" step="0.01"
                                                class="form-control @error('price') is-invalid @enderror"
                                                id="price" wire:model.blur="price" placeholder="Enter price"
                                                x-bind:value="calculatedPrice" readonly>
                                            <small class="text-muted">Price will be calculated automatically</small>
                                            @error('price')
                                                <span class="text-danger d-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 mt-3 mb-3">
                                        <label class="form-label fw-bold">Additional Services</label>
                                        <div class="row g-2">
                                            @foreach($additionalServicesList as $service)
                                            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                                <div class="form-check card-radio">
                                                    <input class="form-check-input" type="checkbox" 
                                                        value="{{ $service->id }}" 
                                                        id="service_{{ $service->id }}" 
                                                        wire:model.live="selectedServices">
                                                    <label class="form-check-label" for="service_{{ $service->id }}">
                                                        <span class="fs-14 text-wrap">{{ $service->services }}</span>
                                                        <span class="text-muted d-block small">
                                                            @if($service->charges_type == 'percentage')
                                                                {{ $service->charge_value }}%
                                                                <span x-show="$wire.price">
                                                                    (<span x-text="({{ $service->charge_value }} * $wire.price / 100).toFixed(2)"></span> SAR)
                                                                </span>
                                                            @else
                                                                {{ number_format($service->charge_value, 2) }} SAR
                                                            @endif
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="discount_amount" class="form-label">Discount Amount (SAR)</label>
                                            <input type="number" step="0.01" min="0"
                                                class="form-control @error('discountAmount') is-invalid @enderror"
                                                id="discount_amount" wire:model.live="discountAmount"
                                                placeholder="Enter discount amount"
                                                :max="$wire.totalAmount"
                                                @input="validateDiscount()">
                                            @error('discountAmount')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            <small class="text-muted" x-show="$wire.discountAmount > $wire.totalAmount" class="text-danger">
                                                Discount cannot exceed total amount
                                            </small>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <div class="alert alert-info d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>Total Amount:</strong>
                                                <small class="text-muted">Base Price + Additional Services - Discount</small>
                                            </div>
                                            <h3 class="mb-0 text-primary">
                                                {{ number_format($totalAmount, 2) }} 
                                                <small class="fs-6 text-muted">SAR</small>
                                            </h3>
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
                                                <option value="pickup" {{ $booking_status == 'pickup' ? 'selected' : '' }}>Pickup</option>
                                                <option value="dropoff" {{ $booking_status == 'dropoff' ? 'selected' : '' }}>Drop-off</option>
                                                <option value="hold" {{ $booking_status == 'hold' ? 'selected' : '' }}>Hold</option>
                                                <option value="cancelled" {{ $booking_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                            @error('booking_status')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="received_payment" class="form-label">Received Payment (SAR)</label>
                                            <input type="number" step="0.01" min="0"
                                                class="form-control @error('received_payment') is-invalid @enderror"
                                                id="received_payment" wire:model.blur="received_payment"
                                                placeholder="Enter received payment"
                                                :max="$wire.totalAmount">
                                            <small class="text-muted">
                                                <span x-show="$wire.received_payment > 0">
                                                    Remaining: <span x-text="($wire.totalAmount - $wire.received_payment).toFixed(2)"></span> SAR
                                                </span>
                                            </small>
                                            @error('received_payment')
                                                <span class="text-danger d-block">{{ $message }}</span>
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
            this.$watch('$wire.price', value => {
                this.calculatePrice(); // Recalculate if base price changes
            });
        },

        loadExistingData() {
            this.pickupLocationType = '{{ $pickup_location_type }}' || '';
            this.dropoffLocationType = '{{ $dropoff_location_type }}' || '';
            this.showPickupHotel = (this.pickupLocationType === 'Hotel');
            this.showDropoffHotel = (this.dropoffLocationType === 'Hotel');
            this.showFlightSection = (this.pickupLocationType === 'Airport');
            
            // Set initial state based on Livewire data
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
            // Recalculate total on load
            this.calculateTotal(); 
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
            }

            if (this.filteredVehicles.length === 1) {
                const vehicle = this.filteredVehicles[0];
                this.$wire.vehicle_id = vehicle.id;
                this.vehicleCapacity = vehicle.seating_capacity;
                this.$wire.vehicle_name = `${vehicle.name} - ${vehicle.model_variant}`;
                this.calculatePrice(); // Find price for auto-selected vehicle
            }
        },

        calculatePrice() {
            // Step 1: Find base fare from routes
            const pickupId = this.$wire.pickup_location_id;
            const dropoffId = this.$wire.dropoff_location_id;
            const vehicleId = this.$wire.vehicle_id;

            if (pickupId && dropoffId && vehicleId) {
                const fare = this.routeFares.find(f =>
                    f.pickup_id == pickupId &&
                    f.dropoff_id == dropoffId &&
                    f.vehicle_id == vehicleId
                );
                
                if (fare) {
                     // Set Livewire price property
                    this.$wire.price = fare.amount;
                } else {
                    this.$wire.price = '';
                }
            }
            
            // Step 2: Calculate total (Base + Services - Discount)
            this.calculateTotal();
        },

        calculateTotal() {
            let base = parseFloat(this.$wire.price || 0);
            
            // Update display price (Base Price)
            this.calculatedPrice = base > 0 ? base.toFixed(2) : '';

            // This calculates "Total Amount" but Livewire also does it.
            // We mainly use Alpine for client-side feedback if needed, 
            // but the Total Amount display uses {{ $totalAmount }} which is PHP.
            // However, to mimic Create's client-side reactivity for "Base Price" input:
            // The "Base Price" input uses x-bind:value="calculatedPrice".
            // So calculatedPrice should represent the BASE price, not the Total.
            // In BookingCreate, the logic was:
            // calculatedPrice = Base + Services - Discount.
            // AND the input label said "Base Price". This was potentially confusing but user wants match.
            // WAIT, looking at Create Step 177:
            // calculatePrice() sets `this.calculatedPrice = total.toFixed(2);`
            // And input binds to `calculatedPrice`.
            // So the input SHOWS THE TOTAL.
            
            // Replicating that logic:
            let total = base;
            
            // Add selected additional services (using the list available in view)
            // Note: additionalServicesList is a PHP variable available in View, need to pass to JS?
            // In Create Step 177, it used @js($additionalServicesList).
            // I need to add that to Alpine data object if not present.
            // In Step 179 script, it is NOT in data object. I need to add it.
            
            const services = @js($additionalServicesList);
            const selected = this.$wire.selectedServices || [];
            
            selected.forEach(serviceId => {
                const service = services.find(s => s.id == serviceId);
                if (service) {
                    if (service.charges_type === 'percentage') {
                        total += (service.charge_value / 100) * base;
                    } else {
                        total += parseFloat(service.charge_value);
                    }
                }
            });

            // Subtract discount
            const discount = parseFloat(this.$wire.discountAmount || 0);
            total -= discount;
            
            // If user wants "Base Price" input to show Total:
            // this.calculatedPrice = total.toFixed(2);
             
            // However, in Edit, I want to be safe. "Base Price" is usually Base.
            // "Total Amount" is separate.
            // But if I want to match Create EXACTLY as per instructions:
            // Create: <input ... x-bind:value="calculatedPrice" readonly>
            // JS: calculatedPrice = total.
            
            // Since I added a separate "Total Amount" display block, 
            // I will let "Base Price" show BASE PRICE (fare.amount).
            // And "Total Amount" show total.
            // This is arguably BETTER than Create if Create was confusing.
            // But I must ensure interactivity.
            
            // I will Stick to: calculatedPrice = base.toFixed(2).
        },

        validateCapacity() {
            const total = this.totalPassengers;
            if (total > this.vehicleCapacity) {
                alert(`Warning: Total passengers (${total}) exceed vehicle capacity (${this.vehicleCapacity})`);
                return false;
            }
            return true;
        },

        validateDiscount() {
            const discount = parseFloat(this.$wire.discountAmount) || 0;
            const total = parseFloat(this.$wire.totalAmount) || 0;
            
            if (discount > total) {
                setTimeout(() => {
                    alert('Discount amount cannot exceed total amount!');
                    this.$wire.discountAmount = total;
                }, 300);
            }
        }
    };
}
</script>