<div>
    <div class="page-content">
        <div class="container-fluid">

            <livewire:admin.components.breadcrumbs title="Create Driver" bredcrumb1="Cars & Driver"
                bredcrumb2="Create Driver" />

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
                                            <label for="name" class="form-label">Driver Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('name') is-invalid @enderror" id="name"
                                                wire:model="name" placeholder="Enter driver name">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Phone Number <span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('phone') is-invalid @enderror" id="phone"
                                                wire:model="phone" placeholder="Enter phone number">
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email Address <span
                                                    class="text-danger">*</span></label>
                                            <input type="email"
                                                class="form-control @error('email') is-invalid @enderror" id="email"
                                                wire:model="email" placeholder="Enter email address">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select @error('driver_status') is-invalid @enderror"
                                                id="driver_status" wire:model="driver_status">
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                            @error('driver_status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="car_id" class="form-label">Assign Car</label>
                                            <select class="form-select @error('car_id') is-invalid @enderror"
                                                id="car_id" wire:model="car_id">
                                                <option value="">Select a car</option>
                                                @foreach ($cars as $car)
                                                    <option value="{{ $car->id }}">{{ $car->name }} -
                                                        {{ $car->model_variant }}</option>
                                                @endforeach
                                            </select>
                                            @error('car_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="dl_expiry" class="form-label">Driving License Expiry</label>
                                            <input type="date"  min="{{ date('Y-m-d') }}"
                                                class="form-control @error('dl_expiry') is-invalid @enderror"
                                                id="dl_expiry" wire:model="dl_expiry">
                                            @error('dl_expiry')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="driver_image" class="form-label">Driver Avatar</label>
                                            <input type="file"
                                                class="form-control @error('driver_image') is-invalid @enderror"
                                                id="driver_image" wire:model="driver_image" accept="image/*">
                                            @error('driver_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div id="driver_image_preview" class="mt-2">
                                                @if ($driver_image)
                                                    <img src="{{ $driver_image->temporaryUrl() }}" alt="Driver Avatar"
                                                        class="img-thumbnail" style="max-height: 100px;">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="car_image" class="form-label">Car Image</label>
                                            <input type="file"
                                                class="form-control @error('car_image') is-invalid @enderror"
                                                id="car_image" wire:model="car_image" accept="image/*">
                                            @error('car_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div id="car_image_preview" class="mt-2">
                                                @if ($car_image)
                                                    <img src="{{ $car_image->temporaryUrl() }}" alt="Car Image"
                                                        class="img-thumbnail" style="max-height: 100px;">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="rc_copy" class="form-label">RC Copy</label>
                                            <input type="file"
                                                class="form-control @error('rc_copy') is-invalid @enderror"
                                                id="rc_copy" wire:model="rc_copy" accept=".pdf"
                                                onchange="previewDocument(this, 'rc_copy_preview', 'RC Copy')">
                                            @error('rc_copy')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div id="rc_copy_preview" class="mt-2">
                                                @if ($rc_copy)
                                                    <div class="d-flex align-items-center gap-2">
                                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="previewExistingDocument('rc_copy', 'RC Copy')">
                                                            <i class="fas fa-eye"></i> Preview
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-outline-danger" wire:click="removeRcCopy">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                        <small class="text-muted">{{ $rc_copy->getClientOriginalName() }}</small>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="insurance_copy" class="form-label">Insurance Copy</label>
                                            <input type="file"
                                                class="form-control @error('insurance_copy') is-invalid @enderror"
                                                id="insurance_copy" wire:model="insurance_copy" accept=".pdf"
                                                onchange="previewDocument(this, 'insurance_copy_preview', 'Insurance Copy')">
                                            @error('insurance_copy')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div id="insurance_copy_preview" class="mt-2">
                                                @if ($insurance_copy)
                                                    <div class="d-flex align-items-center gap-2">
                                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="previewExistingDocument('insurance_copy', 'Insurance Copy')">
                                                            <i class="fas fa-eye"></i> Preview
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-outline-danger" wire:click="removeInsuranceCopy">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                        <small class="text-muted">{{ $insurance_copy->getClientOriginalName() }}</small>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="driving_license" class="form-label">Driving License</label>
                                            <input type="file"
                                                class="form-control @error('driving_license') is-invalid @enderror"
                                                id="driving_license" wire:model="driving_license"
                                                accept=".pdf"
                                                onchange="previewDocument(this, 'driving_license_preview', 'Driving License')">
                                            @error('driving_license')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div id="driving_license_preview" class="mt-2">
                                                @if ($driving_license)
                                                    <div class="d-flex align-items-center gap-2">
                                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="previewExistingDocument('driving_license', 'Driving License')">
                                                            <i class="fas fa-eye"></i> Preview
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-outline-danger" wire:click="removeDrivingLicense">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                        <small class="text-muted">{{ $driving_license->getClientOriginalName() }}</small>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('driver-detail.index') }}" class="btn btn-secondary">
                                                <i class="fas fa-times me-2"></i>Cancel
                                            </a>
                                            <button type="submit" class="btn btn-primary"
                                                wire:loading.attr="disabled">
                                                <span wire:loading.remove>
                                                    <i class="fas fa-save me-2"></i>Save Driver
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
    <!-- Document Preview Modal -->
    <div class="modal fade" id="documentPreviewModal" tabindex="-1" aria-labelledby="documentPreviewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="documentPreviewModalLabel">Document Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <iframe id="documentFrame" src="" width="100%" height="600px"
                        style="border: none;"></iframe>
                </div>
            </div>
        </div>
    </div>

    <script>
        

        function previewExistingDocument(field, documentName) {
            const input = document.getElementById(field);
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const url = URL.createObjectURL(file);
                previewDocumentFile(url, documentName);
            }
        }

        function previewDocument(input, previewId, documentName) {
            const preview = document.getElementById(previewId);
            
            // Clear previous preview
            preview.innerHTML = '';
            
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const fileType = file.type;
                const fileName = file.name.toLowerCase();
                
                // Check if it's a PDF file
                if (fileType === 'application/pdf' || fileName.endsWith('.pdf')) {
                    preview.innerHTML = `
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="previewDocumentFile('${URL.createObjectURL(file)}', '${documentName}')">
                            <i class="fas fa-file-pdf"></i> Preview ${documentName}
                        </button>
                        <br>
                        <small class="text-muted">PDF file: ${file.name}</small>
                    `;
                }
                // Handle other file types
                else {
                    preview.innerHTML = `
                        <div class="alert alert-info py-2">
                            <i class="fas fa-info-circle"></i> 
                            <small>File: ${file.name} (Only PDF files are allowed)</small>
                        </div>
                    `;
                }
            }
        }

        function previewDocumentFile(url, title) {
            const modal = new bootstrap.Modal(document.getElementById('documentPreviewModal'));
            const iframe = document.getElementById('documentFrame');
            const modalTitle = document.getElementById('documentPreviewModalLabel');

            modalTitle.textContent = title + ' - Preview';
            iframe.src = url;
            modal.show();
        }
    </script>
</div>
