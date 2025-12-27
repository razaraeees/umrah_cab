<div>
    <div class="page-content">
        <div class="container-fluid">
            @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <livewire:admin.components.breadcrumbs title="Booking List" bredcrumb1="Booking Management"
                bredcrumb2="Book Listing" />

            <!-- Date Range Filter -->
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                {{-- <div class="col-auto">
                                    <label class="form-label mb-0">Date Range:</label>
                                </div> --}}
                                <div class="col-auto">
                                    <input type="date" class="form-control" wire:model.blur="startDate"
                                        placeholder="Start Date">
                                </div>
                                <div class="col-auto">
                                    <span class="text-muted">to</span>
                                </div>
                                <div class="col-auto">
                                    <input type="date" class="form-control" wire:model.blur="endDate"
                                        placeholder="End Date">
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-primary" wire:click="applyDateRange">
                                        <i class="fas fa-filter me-1"></i>Apply Filter
                                    </button>
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-secondary" wire:click="clearDateRange">
                                        <i class="fas fa-times me-1"></i>Clear
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-3">
                                    <select class="form-select" wire:model.live="dateFilter">
                                        <option value="">All Dates</option>
                                        <option value="today">Today</option>
                                        <option value="tomorrow">Tomorrow</option>
                                        <option value="after_tomorrow">After Tomorrow</option>
                                        <option value="yesterday">Yesterday</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <div class="input-group" style="max-width: 250px;">
                                        <input type="text" class="form-control" placeholder="Search..."
                                            wire:model.live.debounce.500ms="search">
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
                                                        @if ($booking->guest_whatsapp)
                                                            <small class="text-muted">WhatsApp:
                                                                {{ $booking->guest_whatsapp }}</small>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>{{ $booking->vehicle_name ?? 'N/A' }}</td>
                                                <td>
                                                    <div>
                                                        <strong>From:</strong>
                                                        {{ $booking->pickup_location_name ?? 'N/A' }}<br>
                                                        <strong>To:</strong>
                                                        {{ $booking->dropoff_location_name ?? 'N/A' }}
                                                    </div>
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($booking->pickup_date)->format('d M Y') ?? 'N/A' }}
                                                </td>
                                                <td>{{ $booking->pickup_time ?? 'N/A' }}</td>
                                                <td>
                                                    <div>
                                                        <small>Adults: {{ $booking->no_of_adults ?? 0 }}</small><br>
                                                        <small>Children:
                                                            {{ $booking->no_of_children ?? 0 }}</small><br>
                                                        <small>Infants: {{ $booking->no_of_infants ?? 0 }}</small>
                                                    </div>
                                                </td>
                                                <td>{{ number_format($booking->price ?? 0, 2) }} SAR</td>
                                                <td>
                                                    <span
                                                        class="badge {{ $booking->booking_status == 'confirmed' ? 'bg-success' : ($booking->booking_status == 'pending' ? 'bg-warning' : 'bg-danger') }}">
                                                        {{ ucfirst($booking->booking_status ?? 'pending') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-group dropend">
                                                        <button type="button"
                                                            class="btn btn-outline-secondary dropdown-toggle"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            Actions
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <!-- Edit -->
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('booking.edit', $booking->id) }}">
                                                                    <i class="fas fa-edit me-2"></i>Edit record
                                                                </a>
                                                            </li>

                                                            <!-- Delete -->
                                                            <li>
                                                                <a href="javascript:void(0)"
                                                                    class="dropdown-item text-danger"
                                                                    @click.prevent="
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
                                                                    <i class="fas fa-trash me-2"></i>Delete
                                                                </a>
                                                            </li>

                                                            <li>
                                                                <hr class="dropdown-divider">
                                                            </li>

                                                            <!-- Copy Driver -->
                                                            <li>
                                                                <button type="button"
                                                                    class="dropdown-item text-primary"
                                                                    onclick="copyBookingText({{ $booking->id }}, 'driver', this)">
                                                                    <i class="fas fa-car me-2"></i>Copy for Driver
                                                                </button>
                                                            </li>

                                                            <!-- Copy Customer -->
                                                            <li>
                                                                <button type="button"
                                                                    class="dropdown-item text-success"
                                                                    onclick="copyBookingText({{ $booking->id }}, 'customer', this)">
                                                                    <i class="fas fa-user me-2"></i>Copy for Customer
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </div>
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
