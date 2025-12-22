<div>
    <div class="page-content">
        <div class="container-fluid">

            <livewire:admin.components.breadcrumbs title="Create Route Fare" bredcrumb1="Routes & Fares"
                bredcrumb2="Create Route Fare" />

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            @if (session()->has('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <form wire:submit.prevent="save">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="pickupId" class="form-label">Pickup Location <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select @error('pickupId') is-invalid @enderror"
                                                id="pickupId" wire:model.live="pickupId">
                                                <option value="">Select pickup location</option>
                                                @foreach ($pickupLocations as $location)
                                                    <option value="{{ $location->id }}">{{ $location->pickup_location }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('pickupId')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="dropoffId" class="form-label">Dropoff Location <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select @error('dropoffId') is-invalid @enderror"
                                                id="dropoffId" wire:model="dropoffId">
                                                <option value="">Select dropoff location</option>
                                                @foreach ($dropoffLocations as $location)
                                                    <option value="{{ $location->id }}">
                                                        {{ $location->drop_off_location }}</option>
                                                @endforeach
                                            </select>
                                            @error('dropoffId')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="vehicleId" class="form-label">Vehicle</label>
                                            <select class="form-select @error('vehicleId') is-invalid @enderror"
                                                id="vehicleId" wire:model="vehicleId">
                                                <option value="">Select vehicle (optional)</option>
                                                @foreach ($vehicles as $vehicle)
                                                    <option value="{{ $vehicle->id }}">{{ $vehicle->name }} -
                                                        {{ $vehicle->model_variant }} -
                                                        {{ $vehicle->seating_capacity }} Passenger</option>
                                                @endforeach
                                            </select>
                                            @error('vehicleId')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="amount" class="form-label">Amount (SAR) <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" step="0.01" min="0"
                                                class="form-control @error('amount') is-invalid @enderror"
                                                id="amount" wire:model="amount" placeholder="Enter amount">
                                            @error('amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="route_status" class="form-label">route_status <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select @error('route_status') is-invalid @enderror"
                                                id="route_status" wire:model="route_status">
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                            @error('route_status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                     <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="start_date" class="form-label">Start Date <span
                                                    class="text-danger">*</span></label>
                                            <input type="date"
                                                class="form-control @error('start_date') is-invalid @enderror"
                                                id="start_date" wire:model="start_date">
                                            @error('start_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="end_date" class="form-label">End Date <span
                                                    class="text-danger">*</span></label>
                                            <input type="date"
                                                class="form-control @error('end_date') is-invalid @enderror"
                                                id="end_date" wire:model="end_date">
                                            @error('end_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('routefares.index') }}" class="btn btn-secondary">
                                                <i class="fas fa-times me-2"></i>Cancel
                                            </a>
                                            <button type="submit" class="btn btn-primary"
                                                wire:loading.attr="disabled">
                                                <span wire:loading.remove>
                                                    <i class="fas fa-save me-2"></i>Save Route Fare
                                                </span>
                                                <span wire:loading>
                                                    <i class="fas fa-spinner fa-spin me-2"></i>Saving...
                                                </span>
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
