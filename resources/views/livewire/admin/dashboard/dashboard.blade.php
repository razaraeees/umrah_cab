<div>
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <livewire:admin.components.breadcrumbs title="Dashboard" bredcrumb1="Home" bredcrumb2="Dashboard" />
            <!-- end row -->
            <!-- end page title -->

            <!-- Date Filter -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body" style="min-height: 120px;">
                            <div class="row g-2 align-items-end">
                                <div class="col-md-3">
                                    <label class="form-label">Start Date</label>
                                    <input type="date" class="form-control" wire:model.blur="startDate">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">End Date</label>
                                    <input type="date" class="form-control" wire:model.blur="endDate">
                                </div>
                                <div class="col-md-6">
                                    <div class="btn-group">
                                        <button class="btn btn-primary" wire:click="applyDateFilter"
                                            wire:loading.attr="disabled" wire:target="applyDateFilter">

                                            <span wire:loading.remove wire:target="applyDateFilter">
                                                <i class="fas fa-check me-1"></i> Apply Filter
                                            </span>

                                            <span wire:loading wire:target="applyDateFilter">
                                                <i class="fas fa-spinner fa-spin me-1"></i> Loading...
                                            </span>
                                        </button>

                                        <button class="btn btn-secondary" wire:click="clearDateFilter"
                                            wire:loading.attr="disabled" wire:target="clearDateFilter">

                                            <span wire:loading.remove wire:target="clearDateFilter">
                                                <i class="fas fa-times me-1"></i> Clear Filter
                                            </span>

                                            <span wire:loading wire:target="clearDateFilter">
                                                <i class="fas fa-spinner fa-spin me-1"></i> Clearing...
                                            </span>
                                        </button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dashboard Statistics -->
            <div class="row">
                <!-- Total Bookings -->
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body" style="min-height: 120px;">
                            <div class="d-flex">
                                <div class="flex-1">
                                    <h4 class="mb-1">{{ $totalBookings }}</h4>
                                    <h6 class="text-muted font-size-14 mb-0">Total Bookings</h6>
                                </div>
                                <div class="ms-3">
                                    <div class="avatar-sm bg-soft-primary rounded">
                                        <i class="fas fa-calendar-check text-primary font-size-20"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pickup Bookings -->
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body" style="min-height: 120px;">
                            <div class="d-flex">
                                <div class="flex-1">
                                    <h4 class="mb-1">{{ $pickupBookings }}</h4>
                                    <h6 class="text-muted font-size-14 mb-0">Pickup Bookings</h6>
                                </div>
                                <div class="ms-3">
                                    <div class="avatar-sm bg-soft-warning rounded">
                                        <i class="fas fa-car text-warning font-size-20"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dropoff Bookings -->
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body" style="min-height: 120px;">
                            <div class="d-flex">
                                <div class="flex-1">
                                    <h4 class="mb-1">{{ $dropoffBookings }}</h4>
                                    <h6 class="text-muted font-size-14 mb-0">Dropoff Bookings</h6>
                                </div>
                                <div class="ms-3">
                                    <div class="avatar-sm bg-soft-success rounded">
                                        <i class="fas fa-check-circle text-success font-size-20"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cancelled Bookings -->
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body" style="min-height: 120px;">
                            <div class="d-flex">
                                <div class="flex-1">
                                    <h4 class="mb-1">{{ $cancelledBookings }}</h4>
                                    <h6 class="text-muted font-size-14 mb-0">Cancelled Bookings</h6>
                                </div>
                                <div class="ms-3">
                                    <div class="avatar-sm bg-soft-danger rounded">
                                        <i class="fas fa-times-circle text-danger font-size-20"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revenue Statistics -->
            <div class="row mt-4">
                <!-- Total Revenue -->
                <div class="col-xl-4 col-md-6">
                    <div class="card">
                        <div class="card-body" style="min-height: 120px;">
                            <div class="d-flex">
                                <div class="flex-1">
                                    <h4 class="mb-1">{{ number_format($totalRevenue, 2) }} SAR</h4>
                                    <h6 class="text-muted font-size-14 mb-0">Total Revenue</h6>
                                </div>
                                <div class="ms-3">
                                    <div class="avatar-sm bg-soft-info rounded">
                                        <i class="fas fa-wallet text-info font-size-20"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Driver Earnings -->
                <div class="col-xl-4 col-md-6">
                    <div class="card">
                        <div class="card-body" style="min-height: 120px;">
                            <div class="d-flex">
                                <div class="flex-1">
                                    <h4 class="mb-1">{{ number_format($totalDriverEarnings, 2) }} SAR</h4>
                                    <h6 class="text-muted font-size-14 mb-0">Driver Earnings (80%)</h6>
                                </div>
                                <div class="ms-3">
                                    <div class="avatar-sm bg-soft-primary rounded">
                                        <i class="fas fa-user-tie text-primary font-size-20"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Admin Earnings -->
                <div class="col-xl-4 col-md-6">
                    <div class="card">
                        <div class="card-body" style="min-height: 120px;">
                            <div class="d-flex">
                                <div class="flex-1">
                                    <h4 class="mb-1">{{ number_format($totalAdminEarnings, 2) }} SAR</h4>
                                    <h6 class="text-muted font-size-14 mb-0">Admin Earnings (20%)</h6>
                                </div>
                                <div class="ms-3">
                                    <div class="avatar-sm bg-soft-success rounded">
                                        <i class="fas fa-chart-line text-success font-size-20"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end container-fluid -->
    </div>
</div>
