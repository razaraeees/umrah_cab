<div class="d-inline-block">
    <div class="dropdown">
        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="pickupDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-list me-2"></i>Select Pickup
        </button>
        <div class="dropdown-menu" style="width: 300px;">
            <!-- Search input for pickup dropdown -->
            <div class="px-3 py-2">
                <input type="text" class="form-control form-control-sm" 
                    placeholder="Search pickup..." 
                    wire:model.live="pickupSearch">
            </div>
            <div class="dropdown-divider"></div>
            <div style="max-height: 200px; overflow-y: auto;">
                @forelse ($pickUpLocations as $pickUpLocation)
                    <a class="dropdown-item" href="#" wire:click="selectPickup({{ $pickUpLocation->id }})">
                        {{ $pickUpLocation->pickup_location }}
                        <small class="text-muted d-block">{{ $pickUpLocation->type }}</small>
                    </a>
                @empty
                    <a class="dropdown-item disabled">No pickup locations found</a>
                @endforelse
            </div>
        </div>
    </div>
    
    @if ($selectedPickup)
        <div class="btn-group ms-2" role="group">
            <button type="button" class="btn btn-info" disabled>
                <i class="fas fa-filter me-2"></i>{{ $pickUpLocations->find($selectedPickup)->pickup_location ?? 'Selected Pickup' }}
            </button>
            <button type="button" class="btn btn-outline-danger" wire:click="clearPickupFilter">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif
</div>
