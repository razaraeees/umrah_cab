<div>
    <div class="page-content">
        <div class="container-fluid">

            <livewire:admin.components.breadcrumbs title="Routes & Fares" bredcrumb1="Routes & Fares"
                bredcrumb2="Route Listing" />

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center">
                                    <input type="text" class="form-control me-2" placeholder="Search route fares..."
                                        wire:model.live="search" style="width: 300px;">
                                    <select class="form-select" wire:model.live="perPage" style="width: 120px;">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                                <div>
                                    <a href="{{ route('routefares.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Add Route Fare
                                    </a>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th style="font-weight: 600; color: #000;">Routes & Fares</th>
                                            <th style="font-weight: 600; color: #000;">Vehicle</th>
                                            <th style="font-weight: 600; color: #000;">Amount</th>
                                            <th style="font-weight: 600; color: #000;">Start Date</th>
                                            <th style="font-weight: 600; color: #000;">End Date</th>
                                            <th style="font-weight: 600; color: #000;">Status</th>
                                            <th style="font-weight: 600; color: #000;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($routeFares as $routeFare)
                                            <tr>
                                                <td>{{ $routeFare->pickupLocation->pickup_location ?? 'N/A' }} to {{ $routeFare->dropoffLocation->drop_off_location ?? 'N/A' }}</td>
                                                <td>{{ $routeFare->vehicle->name ?? 'N/A' }} -
                                                    {{ $routeFare->vehicle->model_variant ?? '' }} </td>
                                                <td>SAR {{ number_format($routeFare->amount, 2) }}</td>
                                                <td>{{ $routeFare->start_date->format('M d, Y') }}</td>
                                                <td>{{ $routeFare->end_date->format('M d, Y') }}</td>
                                                <td>
                                                    <span
                                                        class="badge {{ $routeFare->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                                        {{ ucfirst($routeFare->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ route('routefares.edit', $routeFare->id) }}"
                                                            class="btn btn-sm btn-primary">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                                            x-data
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
                                                                $wire.delete({{ $routeFare->id }});
                                                                }
                                                            });
                                                        ">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center py-4">
                                                    <p class="text-muted mb-0">No route fares found.</p>
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
</div>
