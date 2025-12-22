<?php

namespace App\Livewire\Components;

use App\Models\PickUpLocation;
use Livewire\Component;

class PickupDropdown extends Component
{
    public $selectedPickup = null;
    public $pickupSearch = '';
    public $pickUpLocations;
    public $isModal = false;

    protected $listeners = ['clearPickupFilter', 'setSelectedPickup'];

    public function mount($isModal = false)
    {
        $this->isModal = $isModal;
        $this->loadPickupLocations();
    }

    public function updatingPickupSearch()
    {
        $this->loadPickupLocations();
    }

    public function loadPickupLocations()
    {
        $query = PickUpLocation::where('status', 'active');
        if ($this->pickupSearch) {
            $query->where('pickup_location', 'like', '%' . $this->pickupSearch . '%');
        }
        $this->pickUpLocations = $query->orderBy('pickup_location')->get();
    }

    public function selectPickup($id)
    {
        $this->selectedPickup = $id;
        
        if ($this->isModal) {
            // For modal, update parent's hidden input
            $this->dispatch('pickupSelectedForModal', pickupId: $id);
        } else {
            // For filter, dispatch filter event
            $this->dispatch('pickupSelected', pickupId: $id);
        }
    }

    public function clearPickupFilter()
    {
        $this->selectedPickup = null;
        
        if ($this->isModal) {
            $this->dispatch('pickupSelectedForModal', pickupId: null);
        } else {
            $this->dispatch('pickupSelected', pickupId: null);
        }
    }

    public function setSelectedPickup($id)
    {
        $this->selectedPickup = $id;
    }

    public function render()
    {
        return view('livewire.components.pickup-dropdown');
    }
}
