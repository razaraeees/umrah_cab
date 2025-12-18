<div>
    <div class="page-content">
        <div class="container-fluid">

            <livewire:admin.components.breadcrumbs title="Driver Details" bredcrumb1="Cars & Driver"
                bredcrumb2="Car Listing" />

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
                                    <a href="{{ route('driver-detail.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Add Driver
                                    </a>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th style="font-weight: 600; color: #000;">Driver Name</th>
                                            <th style="font-weight: 600; color: #000;">Contact</th>
                                            <th style="font-weight: 600; color: #000;">Email</th>
                                            <th style="font-weight: 600; color: #000;">Car Name</th>
                                            <th style="font-weight: 600; color: #000;">Driver Avatar</th>
                                            <th style="font-weight: 600; color: #000;">Car Image</th>
                                            <th style="font-weight: 600; color: #000;">Status</th>
                                            <th style="font-weight: 600; color: #000;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($drivers as $driver)
                                            <tr>
                                                <td>{{ $driver->name ?? 'N/A' }}</td>
                                                <td>{{ $driver->phone ?? 'N/A' }}</td>
                                                <td>{{ $driver->email ?? 'N/A' }}</td>
                                                <td>{{ $driver->carDetails->name ?? 'N/A' }}</td>
                                                <td>
                                                    @if ($driver->driver_image)
                                                        <img src="{{ asset('storage/' . $driver->driver_image) }}"
                                                            alt="Driver Avatar" class="rounded-circle"
                                                            style="width: 40px; height: 40px; object-fit: cover;">
                                                    @else
                                                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center"
                                                            style="width: 40px; height: 40px;">
                                                            <i class="fas fa-user text-white"></i>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($driver->car_image)
                                                        <img src="{{ asset('storage/' . $driver->car_image) }}"
                                                            alt="Car Image"
                                                            style="width: 60px; height: 40px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-light d-flex align-items-center justify-content-center"
                                                            style="width: 60px; height: 40px;">
                                                            <i class="fas fa-car text-muted"></i>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge {{ $driver->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                                        {{ ucfirst($driver->status ?? 'inactive') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('driver-detail.edit', $driver->id) }}"
                                                        class="btn btn-sm btn-outline-secondary me-1">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
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
                                                                    $wire.delete({{ $driver->id }});
                                                                }
                                                            });
                                                        ">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center py-4">
                                                    <p class="text-muted mb-0">No drivers found.</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3">
                                {{ $drivers->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- PDF Preview Modal -->
    <div class="modal fade" id="pdfPreviewModal" tabindex="-1" aria-labelledby="pdfPreviewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfPreviewModalLabel">Document Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <iframe id="pdfFrame" src="" width="100%" height="600px" style="border: none;"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
