<div>
    <div class="page-content">
        <div class="container-fluid">

            <livewire:admin.components.breadcrumbs title="Driver Accounts" bredcrumb1="Accounts"
                bredcrumb2="Driver Accounts" />

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
                                {{-- <div class="col-auto">
                                    <a href="{{ route('driver-detail.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Add Driver
                                    </a>
                                </div> --}}
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
                                            <th style="font-weight: 600; color: #000;">Total Rides</th>
                                            <th style="font-weight: 600; color: #000;">Total Amount</th>
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
                                                <td>{{ $driver->bookings->count() }}</td>
                                                <td>{{ number_format($driver->bookings->sum('total_amount') ?? 0, 2) }} SAR</td>
                                                <td>
                                                    <span
                                                        class="badge {{ $driver->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                                        {{ ucfirst($driver->status ?? 'inactive') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('driver-account.details', $driver->id) }}" 
                                                        class="btn btn-sm btn-outline-info me-1">
                                                        <i class="fas fa-eye"></i> Details
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
                                                <td colspan="8" class="text-center py-4">
                                                    <p class="text-muted mb-0">No drivers with bookings found.</p>
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

    <!-- Driver Details Modal -->
    @if ($showDetailsModal)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Driver Details - {{ $selectedDriver->name ?? 'N/A' }}</h5>
                        <button type="button" class="btn-close" wire:click="closeDetailsModal"></button>
                    </div>
                    <div class="modal-body">
                        @if ($selectedDriver)
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Driver Name:</strong> {{ $selectedDriver->name ?? 'N/A' }}
                                </div>
                                <div class="col-md-6">
                                    <strong>Contact:</strong> {{ $selectedDriver->phone ?? 'N/A' }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Email:</strong> {{ $selectedDriver->email ?? 'N/A' }}
                                </div>
                                <div class="col-md-6">
                                    <strong>Car:</strong> {{ $selectedDriver->carDetails->name ?? 'N/A' }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Total Rides:</strong> {{ $driverBookings->count() }}
                                </div>
                                <div class="col-md-6">
                                    <strong>Total Earnings:</strong> {{ number_format($driverBookings->sum('price') ?? 0, 2) }} SAR
                                </div>
                            </div>
                            
                            <h6 class="mt-4 mb-3">Booking History</h6>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Guest Name</th>
                                            <th>Pickup Date</th>
                                            <th>Route</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($driverBookings as $booking)
                                            <tr>
                                                <td>{{ $booking->guest_name ?? 'N/A' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($booking->pickup_date)->format('d M Y') }}</td>
                                                <td>{{ $booking->pickup_location_name }} → {{ $booking->dropoff_location_name }}</td>
                                                <td>{{ number_format($booking->price ?? 0, 2) }} SAR</td>
                                                <td>
                                                    <span class="badge bg-secondary">
                                                        {{ ucfirst($booking->booking_status ?? 'N/A') }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No bookings found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeDetailsModal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

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
