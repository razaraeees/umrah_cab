<div>
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <livewire:admin.components.breadcrumbs title="Pick Up Location" bredcrumb1="Booking Managemnet"
                bredcrumb2="Pick Up Location" />
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search..."
                                            wire:model.debounce.300ms="search">
                                        <span class="input-group-text bg-transparent border-0" wire:loading
                                            wire:target="search">
                                            <span class="spinner-border spinner-border-sm text-primary"
                                                role="status"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-2 ms-auto">
                                    <!-- Alpine.js se modal toggle -->
                                    <button type="button" class="btn btn-primary w-100" 
                                            wire:click="openModal">
                                        <i class="fas fa-plus me-2"></i>Add More
                                    </button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead style="background-color: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                                        <tr>
                                            <th style="font-weight: 600; color: #000; padding: 12px;">Pick Up Location</th>
                                            <th style="font-weight: 600; color: #000; padding: 12px;">Type</th>
                                            <th style="font-weight: 600; color: #000; padding: 12px;">Status</th>
                                            <th style="font-weight: 600; color: #000; padding: 12px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($pickUps as $pickUp)
                                            <tr>
                                                <td>{{ $pickUp->pickup_location ?? '' }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $pickUp->type == 'airport' ? 'primary' : ($pickUp->type == 'hotel' ? 'success' : ($pickUp->type == 'city' ? 'warning' : 'secondary')) }}">
                                                        {{ ucfirst($pickUp->type ?? '') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if ($pickUp->status == 'active')
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-danger">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-outline-warning me-1"
                                                        wire:click="edit({{ $pickUp->id }})">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                        wire:click="delete({{ $pickUp->id }})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-4">
                                                    <p class="text-muted mb-0">No pick-up locations found.</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Alpine.js Modal (Bootstrap styling ke saath) -->
    <div x-data="{ show: @entangle('showModal') }" 
         x-show="show" 
         x-cloak
         @keydown.escape.window="show = false"
         class="modal fade show" 
         style="display: none;"
         x-bind:style="show ? 'display: block;' : 'display: none;'"
         tabindex="-1">
        
        <!-- Backdrop -->
        <div class="modal-backdrop fade" 
             x-show="show" 
             x-transition
             x-bind:class="show ? 'show' : ''"
             @click="show = false"></div>
        
        <div class="modal-dialog" x-show="show" x-transition>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ $editMode ? 'Edit' : 'Add' }} Pick Up Location
                    </h5>
                    <button type="button" class="btn-close" @click="show = false"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="pickupLocation" class="form-label">Pick Up Location</label>
                            <input type="text" class="form-control @error('pick_up_location') is-invalid @enderror" 
                                   id="pickupLocation" 
                                   wire:model.defer="pick_up_location" 
                                   placeholder="Enter pick up location">
                            @error('pick_up_location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">Type</label>
                            <select class="form-select @error('type') is-invalid @enderror" 
                                    id="type" 
                                    wire:model.defer="type">
                                <option value="">Select Type</option>
                                <option value="airport">Airport</option>
                                <option value="hotel">Hotel</option>
                                <option value="city">City</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="pickup_status" class="form-label">Status</label>
                            <select class="form-select @error('pickup_status') is-invalid @enderror" 
                                    id="pickup_status" 
                                    wire:model.defer="pickup_status">
                                <option value="">Select Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                            @error('pickup_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" @click="show = false">Close</button>
                    <button type="button" class="btn btn-primary" wire:click="save" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="save">Save</span>
                        <span wire:loading wire:target="save">
                            <span class="spinner-border spinner-border-sm me-1"></span>
                            Saving...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Alpine.js cloaking style -->
    <style>
        [x-cloak] { display: none !important; }
        .modal-backdrop { position: fixed; top: 0; left: 0; z-index: 1040; width: 100vw; height: 100vh; background-color: #000; opacity: 0.5; }
        .modal.show { z-index: 1050; }
    </style>
</div>