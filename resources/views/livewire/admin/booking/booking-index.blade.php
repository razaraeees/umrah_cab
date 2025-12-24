<div>
    <div class="page-content">
        <div class="container-fluid">
            @if(session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <livewire:admin.components.breadcrumbs title="Booking List" bredcrumb1="Booking Management"
                bredcrumb2="Book Listing" />

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
                                    <a href="{{ route('booking.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Add Booking
                                    </a>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th style="font-weight: 600; color: #000;">Customer Name</th>
                                            <th style="font-weight: 600; color: #000;">Contact</th>
                                            <th style="font-weight: 600; color: #000;">Vehicle</th>
                                            <th style="font-weight: 600; color: #000;">Route</th>
                                            <th style="font-weight: 600; color: #000;">Pickup Date</th>
                                            <th style="font-weight: 600; color: #000;">Pickup Time</th>
                                            <th style="font-weight: 600; color: #000;">Passengers</th>
                                            <th style="font-weight: 600; color: #000;">Price</th>
                                            <th style="font-weight: 600; color: #000;">Status</th>
                                            <th style="font-weight: 600; color: #000;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($bookings as $booking)
                                            <tr>
                                                <td>{{ $booking->guest_name ?? 'N/A' }}</td>
                                                <td>
                                                    <div>
                                                        <strong>Phone:</strong> {{ $booking->guest_phone ?? 'N/A' }}<br>
                                                        @if($booking->guest_whatsapp)
                                                            <small class="text-muted">WhatsApp: {{ $booking->guest_whatsapp }}</small>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>{{ $booking->vehicle_name ?? 'N/A' }}</td>
                                                <td>
                                                    <div>
                                                        <strong>From:</strong> {{ $booking->pickup_location_name ?? 'N/A' }}<br>
                                                        <strong>To:</strong> {{ $booking->dropoff_location_name ?? 'N/A' }}
                                                    </div>
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($booking->pickup_date)->format('d M Y') ?? 'N/A' }}</td>
                                                <td>{{ $booking->pickup_time ?? 'N/A' }}</td>
                                                <td>
                                                    <div>
                                                        <small>Adults: {{ $booking->no_of_adults ?? 0 }}</small><br>
                                                        <small>Children: {{ $booking->no_of_children ?? 0 }}</small><br>
                                                        <small>Infants: {{ $booking->no_of_infants ?? 0 }}</small>
                                                    </div>
                                                </td>
                                                <td>{{ number_format($booking->price ?? 0, 2) }} SAR</td>
                                                <td>
                                                    <span class="badge {{ $booking->booking_status == 'confirmed' ? 'bg-success' : ($booking->booking_status == 'pending' ? 'bg-warning' : 'bg-danger') }}">
                                                        {{ ucfirst($booking->booking_status ?? 'pending') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('booking.edit', $booking->id) }}"
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
                                                                    $wire.delete({{ $booking->id }});
                                                                }
                                                            });
                                                        ">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10" class="text-center py-4">
                                                    <p class="text-muted mb-0">No bookings found.</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3">
                                {{ $bookings->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
