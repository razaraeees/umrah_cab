<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <div class="page-content">
        <div class="container-fluid">
            <livewire:admin.components.breadcrumbs title="Car Edit" bredcrumb1="Booking Management"
                bredcrumb2="Car Edit" />

            <div class="mb-2 d-flex justify-content-end">
                <a href="{{ route('car-detail.index') }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Back to List
                </a>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6 class="text-uppercase text-muted fw-semibold mb-3">Edit Car</h6>
                            <form class="needs-validation" wire:submit.prevent="update" novalidate>
                                <h6 class="text-uppercase text-muted fw-semibold mb-3">Basic Information</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="carName" class="form-label">Car Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                id="carName" placeholder="Enter car name" wire:model.defer="name">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- end col -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="modelVariant" class="form-label">Model Variant <span class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('model_variant') is-invalid @enderror"
                                                id="modelVariant" placeholder="Enter model variant"
                                                wire:model.defer="model_variant">
                                            @error('model_variant')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- end col -->
                                </div>
                                <!-- end row -->

                                <h6 class="text-uppercase text-muted fw-semibold mb-3 mt-2">Specifications</h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-4">
                                            <label for="carType" class="form-label">Car Type</label>
                                            <select class="form-select @error('car_type') is-invalid @enderror"
                                                id="carType" wire:model.defer="car_type">
                                                <option value="">Select car type</option>
                                                <option value="sedan">Sedan</option>
                                                <option value="suv">SUV</option>
                                                <option value="van">Van</option>
                                                <option value="other">Other</option>
                                            </select>
                                            @error('car_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- end col -->
                                    <div class="col-md-4">
                                        <div class="mb-4">
                                            <label for="color" class="form-label">Color <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('color') is-invalid @enderror"
                                                id="color" placeholder="Enter color" wire:model.defer="color">
                                            @error('color')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- end col -->
                                    <div class="col-md-4">
                                        <div class="mb-4">
                                            <label for="seatingCapacity" class="form-label">Seating Capacity <span class="text-danger">*</span></label>
                                            <input type="number"
                                                class="form-control @error('seating_capacity') is-invalid @enderror"
                                                id="seatingCapacity" placeholder="Enter seating capacity"
                                                wire:model.defer="seating_capacity">
                                            @error('seating_capacity')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- end col -->
                                </div>
                                <!-- end row -->

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="door" class="form-label">Door</label>
                                            <input type="text" class="form-control @error('door') is-invalid @enderror"
                                                id="door" placeholder="e.g. 4 Door" wire:model.defer="door">
                                            @error('door')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- end col -->
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="bagCapacity" class="form-label">Bag Capacity</label>
                                            <input type="text" class="form-control @error('bag_capacity') is-invalid @enderror"
                                                id="bagCapacity" placeholder="e.g. 2 Large, 1 Small" wire:model.defer="bag_capacity">
                                            @error('bag_capacity')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- end col -->
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="year" class="form-label">Year</label>
                                            <input type="text" class="form-control @error('year') is-invalid @enderror"
                                                id="year" placeholder="e.g. 2024" wire:model.defer="year">
                                            @error('year')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- end col -->
                                </div>
                                <!-- end row -->

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="fuelType" class="form-label">Fuel Type</label>
                                            <input type="text" class="form-control @error('fuel_type') is-invalid @enderror"
                                                id="fuelType" placeholder="e.g. Petrol, Diesel" wire:model.defer="fuel_type">
                                            @error('fuel_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- end col -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="registrationNumber" class="form-label">Registration
                                                Number</label>
                                            <input type="text" class="form-control @error('registration_number') is-invalid @enderror"
                                                id="registrationNumber" placeholder="Enter registration number"
                                                wire:model.defer="registration_number">
                                            @error('registration_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- end col -->
                                </div>
                                <!-- end row -->

                                <div class="d-flex justify-content-end mt-2">
                                    <a href="{{ route('car-detail.index') }}" class="btn btn-light me-2">Cancel</a>
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-save me-1"></i>Update Car
                                    </button>
                                </div>
                            </form>
                            <!-- end form -->
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
