<div class="page-content">
    <div class="container-fluid">

        <livewire:admin.components.breadcrumbs title="Driver Details" bredcrumb1="Accounts"
            bredcrumb2="Driver Accounts" bredcrumb3="Driver Details" />

        @if ($driver)
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                <!-- Driver Profile Section -->
                                <div class="col-md-3">
                                    <div class="text-center">
                                        @if ($driver->driver_image)
                                            <img src="{{ asset('storage/' . $driver->driver_image) }}" 
                                                alt="Driver Avatar" class="rounded-circle mb-3 shadow"
                                                style="width: 140px; height: 140px; object-fit: cover; border: 4px solid #f0f0f0;">
                                        @else
                                            <div class="rounded-circle bg-gradient d-flex align-items-center justify-content-center mb-3 shadow"
                                                style="width: 140px; height: 140px; margin: 0 auto; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: 4px solid #f0f0f0;">
                                                <i class="fas fa-user text-white fa-4x"></i>
                                            </div>
                                        @endif
                                        <h4 class="mb-2 fw-bold">{{ $driver->name ?? 'N/A' }}</h4>
                                        <span class="badge px-3 py-2 {{ $driver->status == 'active' ? 'bg-success' : 'bg-danger' }}" 
                                            style="font-size: 0.85rem;">
                                            <i class="fas fa-circle me-1" style="font-size: 0.6rem;"></i>
                                            {{ ucfirst($driver->status ?? 'inactive') }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Driver Information Section -->
                                <div class="col-md-9">
                                    <div class="row g-4">
                                        <!-- Contact Information -->
                                        <div class="col-md-6">
                                            <div class="info-card p-3 rounded" style="background: #f8f9fa;">
                                                <h6 class="text-muted text-uppercase mb-3" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                                                    Contact Information
                                                </h6>
                                                <div class="mb-3">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="fas fa-phone-alt text-primary me-2" style="width: 20px;"></i>
                                                        <span class="text-muted small">Phone:</span>
                                                    </div>
                                                    <div class="ms-4">
                                                        <strong>{{ $driver->phone ?? 'N/A' }}</strong>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="fas fa-envelope text-primary me-2" style="width: 20px;"></i>
                                                        <span class="text-muted small">Email:</span>
                                                    </div>
                                                    <div class="ms-4">
                                                        <strong style="word-break: break-all;">{{ $driver->email ?? 'N/A' }}</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Vehicle Information -->
                                        <div class="col-md-6">
                                            <div class="info-card p-3 rounded" style="background: #f8f9fa;">
                                                <h6 class="text-muted text-uppercase mb-3" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                                                    Vehicle Information
                                                </h6>
                                                <div class="mb-3">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="fas fa-car text-primary me-2" style="width: 20px;"></i>
                                                        <span class="text-muted small">Car Model:</span>
                                                    </div>
                                                    <div class="ms-4">
                                                        <strong>{{ $driver->carDetails->name ?? 'N/A' }}</strong>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="fas fa-id-card text-primary me-2" style="width: 20px;"></i>
                                                        <span class="text-muted small">Registration:</span>
                                                    </div>
                                                    <div class="ms-4">
                                                        <strong>{{ $driver->carDetails->registration_number ?? 'N/A' }}</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Statistics Cards -->
                                        <div class="col-md-4">
                                            <div class="stat-card p-3 rounded border" style="border-left: 4px solid #4CAF50 !important; background: #fff;">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <p class="text-muted mb-1 small">Total Rides</p>
                                                        <h3 class="mb-0 fw-bold">{{ $driver->bookings->count() }}</h3>
                                                    </div>
                                                    <div class="stat-icon">
                                                        <i class="fas fa-route fa-2x" style="color: #4CAF50; opacity: 0.7;"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="stat-card p-3 rounded border" style="border-left: 4px solid #2196F3 !important; background: #fff;">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <p class="text-muted mb-1 small">Total Driver Earnings</p>
                                                        <h3 class="mb-0 fw-bold">{{ number_format($driver->bookings->sum('total_amount') * 0.8 ?? 0, 2) }} <span class="fs-6">SAR</span></h3>
                                                    </div>
                                                    <div class="stat-icon">
                                                        <i class="fas fa-wallet fa-2x" style="color: #2196F3; opacity: 0.7;"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="stat-card p-3 rounded border" style="border-left: 4px solid #f32121ff !important; background: #fff;">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <p class="text-muted mb-1 small">Total Admin Earnings</p>
                                                        <h3 class="mb-0 fw-bold">{{ number_format($driver->bookings->sum('total_amount') * 0.2 ?? 0, 2) }} <span class="fs-6">SAR</span></h3>
                                                    </div>
                                                    <div class="stat-icon">
                                                        <i class="fas fa-wallet fa-2x" style="color: #f32121ff; opacity: 0.7;"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bookings Table Section (unchanged) -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="card-title mb-0 fw-bold">Ride History</h5>
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-success" wire:click="generatePDF">
                                            <i class="fas fa-file-pdf me-1"></i> Generate PDF
                                        </button>
                                    </div>
                                </div>
                            
                            <div class="mb-3">
                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <input type="date" class="form-control" placeholder="Start Date"
                                            wire:model.blur="startDate">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="date" class="form-control" placeholder="End Date"
                                            wire:model.blur="endDate">
                                    </div>
                                    <div class="col-md-4">
                                        <div class="btn-group w-100">
                                            <button class="btn btn-primary" wire:click="applyDateRange">
                                                <i class="fas fa-check me-1"></i> Apply
                                            </button>
                                            <button class="btn btn-secondary" wire:click="clearDateRange">
                                                <i class="fas fa-times me-1"></i> Clear
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover align-middle" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="font-weight: 600; color: #000;">Guest Name</th>
                                            <th style="font-weight: 600; color: #000;">Contact</th>
                                            <th style="font-weight: 600; color: #000;">Pickup Date</th>
                                            <th style="font-weight: 600; color: #000;">Pickup Time</th>
                                            <th style="font-weight: 600; color: #000;">Route</th>
                                            <th style="font-weight: 600; color: #000;">Route Fare</th>
                                            <th style="font-weight: 600; color: #000;">Discount</th>
                                            <th style="font-weight: 600; color: #000;">Additional Services</th>
                                            <th style="font-weight: 600; color: #000;">Total Amount</th>
                                            <th style="font-weight: 600; color: #000;">Status</th>
                                            <th style="font-weight: 600; color: #000;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($bookings as $booking)
                                            <tr>
                                                <td>{{ $booking->guest_name ?? 'N/A' }}</td>
                                                <td>{{ $booking->guest_phone ?? 'N/A' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($booking->pickup_date)->format('d M Y') }}</td>
                                                <td>{{ $booking->pickup_time ?? 'N/A' }}</td>
                                                <td>
                                                    <small>
                                                        {{ $booking->pickup_location_name }}<br>
                                                        <i class="fas fa-arrow-down"></i> {{ $booking->dropoff_location_name }}
                                                    </small>
                                                </td>
                                                <td><strong>{{ number_format($booking->price ?? 0, 2) }} SAR</strong></td>
                                                <td><strong>{{ number_format($booking->discount_amount ?? 0, 2) }} SAR</strong></td>
                                                <td>
                                                    @if ($booking->additionalServices->count() > 0)
                                                        @foreach ($booking->additionalServices as $service)
                                                            <small class="d-block">{{ $service->name }} ({{ number_format($service->pivot->amount ?? 0, 2) }} SAR)</small>
                                                        @endforeach
                                                    @else
                                                        <small class="text-muted">No services</small>
                                                    @endif
                                                </td>
                                                <td><strong>{{ number_format($booking->total_amount ?? 0, 2) }} SAR</strong></td>
                                                <td>
                                                    <span class="badge bg-secondary">
                                                        {{ ucfirst($booking->booking_status ?? 'N/A') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('booking.edit', $booking->id) }}"
                                                        class="btn btn-sm btn-outline-secondary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10" class="text-center py-4">
                                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                                    <p class="text-muted mb-0">No rides found.</p>
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
        @else
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-user-slash fa-4x text-muted mb-3"></i>
                            <h4>Driver not found</h4>
                            <p class="text-muted">The driver you're looking for doesn't exist.</p>
                            <a href="{{ route('driver-account.index') }}" class="btn btn-primary mt-3">
                                <i class="fas fa-arrow-left me-2"></i> Back to Driver Accounts
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>