<div>
    <div class="page-content">
        <div class="container-fluid">

            <livewire:admin.components.breadcrumbs title="Hotels" bredcrumb1="Booking Management"
                bredcrumb2="Hotels" />

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-3 align-items-center">
                                <div class="col">
                                    <div class="input-group" style="max-width: 250px;">
                                        <input type="text" class="form-control" placeholder="Search..."
                                            wire:model.live="search">
                                        <span class="input-group-text bg-transparent border-0" wire:loading
                                            wire:target="search">
                                            <span class="spinner-border spinner-border-sm text-primary"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="dropdown">
                                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="cityDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-list me-2"></i>Select City
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="cityDropdown" style="max-height: 300px; overflow-y: auto;">
                                            @forelse ($cities as $city)
                                                <li><a class="dropdown-item" href="#" wire:click="selectCity({{ $city->id }})">{{ $city->name }}</a></li>
                                            @empty
                                                <li><a class="dropdown-item disabled">No cities found</a></li>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                                @if ($selectedCity)
                                    <div class="col-auto">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-info" disabled>
                                                <i class="fas fa-filter me-2"></i>{{ $cities->find($selectedCity)->name ?? 'Selected City' }}
                                            </button>
                                            <button type="button" class="btn btn-outline-danger" wire:click="clearCityFilter">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-auto">
                                    <button type="button" class="btn btn-primary" wire:click="openModal">
                                        <i class="fas fa-plus me-2"></i>Add More
                                    </button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th style="font-weight: 600; color: #000;">Hotel Name</th>
                                            <th style="font-weight: 600; color: #000;">City</th>
                                            <th style="font-weight: 600; color: #000;">Status</th>
                                            <th style="font-weight: 600; color: #000;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($hotels as $hotel)
                                            <tr>
                                                <td>{{ $hotel->name ?? '' }}</td>
                                                <td>{{ $hotel->city->name ?? 'N/A' }}</td>
                                                <td>
                                                    @if ($hotel->status)
                                                        <span class="badge badge-status-active">Active</span>
                                                    @else
                                                        <span class="badge badge-status-inactive">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-outline-secondary me-1"
                                                        wire:click="edit({{ $hotel->id }})">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-danger" x-data
                                                        @click="
                                                            $event.preventDefault();
                                                            Swal.fire({
                                                                title: 'Are you sure?',
                                                                text: 'You won\'t be able to revert this!',
                                                                icon: 'warning',
                                                                showCancelButton: true,
                                                                confirmButtonColor: '#d33',
                                                                cancelButtonColor: '#3085d6',
                                                                confirmButtonText: 'Yes, delete it!',
                                                                cancelButtonText: 'Cancel'
                                                            }).then((result) => {
                                                                if (result.isConfirmed) {
                                                                    $wire.delete({{ $hotel->id }});
                                                                }
                                                            });
                                                        ">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-4">
                                                    <p class="text-muted mb-0">No hotels found.</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3">
                                {{ $hotels->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @if ($showModal)
        <div class="custom-modal-wrapper">
            <!-- Backdrop -->
            <div class="custom-modal-backdrop" wire:click="closeModal"></div>

            <!-- Modal Dialog -->
            <div class="custom-modal-dialog custom-modal-{{ $size ?? 'md' }}">
                <div class="custom-modal-content">

                    {{-- Optional header --}}
                    @if (!empty($showHeader ?? true))
                        <div class="modal-header">
                            <h5 class="modal-title">
                                {{ $editMode ? 'Edit Hotel' : 'Add Hotel' }}
                            </h5>
                            <button type="button" class="btn-close" wire:click="closeModal"></button>
                        </div>
                    @endif

                    <div class="modal-body">
                        <form wire:submit.prevent="save">
                            <div class="mb-3">
                                <label for="hotelName" class="form-label">
                                    Hotel Name <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    id="hotelName" wire:model.defer="name"
                                    placeholder="Enter hotel name">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="cityId" class="form-label">
                                    City <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('cityId') is-invalid @enderror"
                                    id="cityId" wire:model.defer="cityId">
                                    <option value="">Select City</option>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                                @error('cityId')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">
                                    Status <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('status') is-invalid @enderror"
                                    id="status" wire:model.defer="status">
                                    <option value="">Select Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" wire:click="closeModal">Close</button>
                        <button type="button" class="btn btn-primary" wire:click="save"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="save">
                                <i class="fas fa-save me-1"></i>Save
                            </span>
                            <span wire:loading wire:target="save">
                                <span class="spinner-border spinner-border-sm me-1"></span>Saving...
                            </span>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    @endif

</div>
