<div>
    <div class="page-content">
        <div class="container-fluid">

            <livewire:admin.components.breadcrumbs title="Car Details" bredcrumb1="Booking Management"
                bredcrumb2="Car Details" />

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
                                    <a href="{{ route('car-detail.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Add More
                                    </a>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th style="font-weight: 600; color: #000;">Car Name</th>
                                            <th style="font-weight: 600; color: #000;">Model Variant</th>
                                            <th style="font-weight: 600; color: #000;">Car Type</th>
                                            <th style="font-weight: 600; color: #000;">Seating Capacity</th>
                                            <th style="font-weight: 600; color: #000;">Air Condition</th>
                                            <th style="font-weight: 600; color: #000;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($cars as $car)
                                            <tr>
                                                <td>{{ $car->name ?? 'N/A' }}</td>
                                                <td>{{ $car->model_variant ?? 'N/A' }}</td>
                                                <td>
                                                    <span class="badge badge-status-active">{{ ucfirst($car->car_type ?? '') }}</span>
                                                </td>
                                                <td>
                                                    {{ $car->seating_capacity ?? 'N/A' }}
                                                </td>
                                                <td>
                                                    @if($car->air_condition)
                                                        <span class="badge bg-success">Yes</span>
                                                    @else
                                                        <span class="badge bg-danger">No</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('car-detail.edit', $car->id) }}" class="btn btn-sm btn-outline-secondary me-1">
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
                                                                    $wire.delete({{ $car->id }});
                                                                }
                                                            });
                                                        ">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-4">
                                                    <p class="text-muted mb-0">No cars found.</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3">
                                {{ $cars->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
