<div>
    <div class="page-content">
        <div class="container-fluid">

            <livewire:admin.components.breadcrumbs title="Additional Charges" bredcrumb1="Booking Management"
                bredcrumb2="Additional Charges" />

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
                                            <th style="font-weight: 600; color: #000;">Service Name</th>
                                            <th style="font-weight: 600; color: #000;">Charges Type</th>
                                            <th style="font-weight: 600; color: #000;">Charge Value</th>
                                            <th style="font-weight: 600; color: #000;">Type</th>
                                            <th style="font-weight: 600; color: #000;">Status</th>
                                            <th style="font-weight: 600; color: #000;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($additionalServices as $service)
                                            <tr>
                                                <td>{{ $service->services }}</td>
                                                <td>
                                                    <span class="text-dark">
                                                        {{ ucfirst($service->charges_type) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($service->charges_type == 'percentage')
                                                        {{ $service->charge_value }}%
                                                    @else
                                                        SAR {{ number_format($service->charge_value, 2) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge badge-status-active">{{ ucfirst($service->type ?? 'N/A') }}</span>
                                                </td>
                                                <td>
                                                    @if ($service->status == 'Active')
                                                        <span class="badge badge-status-active">Active</span>
                                                    @else
                                                        <span class="badge badge-status-inactive">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-outline-secondary me-1"
                                                        wire:click="edit({{ $service->id }})">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-{{ $service->status == 'Active' ? 'warning' : 'success' }} me-1"
                                                        wire:click="toggleStatus({{ $service->id }})">
                                                        <i class="fas fa-{{ $service->status == 'Active' ? 'eye-slash' : 'eye' }}"></i>
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
                                                                    $wire.delete({{ $service->id }});
                                                                }
                                                            });
                                                        ">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-4">
                                                    <p class="text-muted mb-0">No additional services found.</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3">
                                {{ $additionalServices->links() }}
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
                                {{ $editMode ? 'Edit Additional Service' : 'Add Additional Service' }}
                            </h5>
                            <button type="button" class="btn-close" wire:click="closeModal"></button>
                        </div>
                    @endif

                    <div class="modal-body">
                        <form wire:submit.prevent="save">
                            <div class="mb-3">
                                <label for="services" class="form-label">
                                    Service Name <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                    class="form-control @error('services') is-invalid @enderror"
                                    id="services" wire:model.defer="services"
                                    placeholder="Enter service name">
                                @error('services')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="charges_type" class="form-label">
                                    Charges Type <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('charges_type') is-invalid @enderror" id="charges_type"
                                    wire:model.defer="charges_type">
                                    <option value="">Select Charges Type</option>
                                    <option value="fixed">Fixed Amount</option>
                                    <option value="percentage">Percentage</option>
                                </select>
                                @error('charges_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="charge_value" class="form-label">
                                    Charge Value <span class="text-danger">*</span>
                                    <small class="text-muted">(@if($charges_type == 'percentage') percentage @else fixed amount in SAR @endif)</small>
                                </label>
                                <input type="number"
                                    class="form-control @error('charge_value') is-invalid @enderror"
                                    id="charge_value" wire:model.defer="charge_value"
                                    step="0.01" min="0"
                                    placeholder="Enter charge value">
                                @error('charge_value')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="type" class="form-label">
                                    Service Type
                                </label>
                                <select class="form-select @error('type') is-invalid @enderror" id="type"
                                    wire:model.defer="type">
                                    <option value="">Select Service Type</option>
                                    <option value="airport">Airport</option>
                                    <option value="hotel">Hotel</option>
                                    <option value="city">City</option>
                                    <option value="ziyarat">Ziyarat</option>
                                    <option value="guide">Guide</option>
                                    <option value="transport">Transport</option>
                                    <option value="food">Food</option>
                                    <option value="other">Other</option>
                                </select>
                                @error('type')
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
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" wire:click="closeModal">Close</button>
                        <button type="button" class="btn btn-primary" wire:click="save" wire:loading.attr="disabled">
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