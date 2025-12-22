<?php

namespace App\Livewire\Admin\DropOff;

use App\Models\DropLocation;
use Livewire\Component;
use Livewire\WithPagination;

class DropOff extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $showModal = false;
    public $editMode = false;
    public $dropoffId;

    public $pick_up_location_id = '';
    public $drop_off_location = '';
    public $type = '';
    public $status = '';

    protected $rules = [
        'pick_up_location_id' => 'required|exists:pick_up_locations,id',
        'drop_off_location' => 'required|string|max:255',
        'type' => 'required|in:airport,hotel,city,other,ziyarat,guide',
        'status' => 'required|in:active,inactive',
    ];

    protected $messages = [
        'pick_up_location_id.required' => 'Pick up location is required.',
        'pick_up_location_id.exists' => 'Selected pick up location does not exist.',
        'drop_off_location.required' => 'Drop off location is required.',
        'type.required' => 'Type is required.',
        'status.required' => 'Status is required.',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openModal()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->showModal = true;
        $this->dispatch('modalOpened');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
        $this->dispatch('modalClosed');
    }

    public function edit($id)
    {
        $dropOff = DropLocation::findOrFail($id);

        $this->dropoffId = $id;
        $this->pick_up_location_id = $dropOff->pick_up_location_id;
        $this->drop_off_location = $dropOff->drop_off_location;
        $this->type = $dropOff->type;
        $this->status = $dropOff->status;

        $this->editMode = true;
        $this->showModal = true;
    }

    public function save()
    {
        $validated = $this->validate();

        try {
            if ($this->editMode) {
                $dropOff = DropLocation::findOrFail($this->dropoffId);
                $dropOff->update([
                    'pick_up_location_id' => $validated['pick_up_location_id'],
                    'drop_off_location' => $validated['drop_off_location'],
                    'type' => $validated['type'],
                    'status' => $validated['status'],
                ]);

                $this->dispatch('show-toast', type: 'success', message: 'Drop off location updated successfully.');
            } else {
                DropLocation::create([
                    'pick_up_location_id' => $validated['pick_up_location_id'],
                    'drop_off_location' => $validated['drop_off_location'],
                    'type' => $validated['type'],
                    'status' => $validated['status'],
                ]);

                $this->dispatch('show-toast', type: 'success', message: 'Drop off location created successfully.');
            }

            $this->closeModal();
        } catch (\Exception $e) {
            $this->dispatch('show-toast', type: 'error', message: 'Error: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            DropLocation::findOrFail($id)->delete();
            $this->dispatch('show-toast', type: 'success', message: 'Drop off location deleted successfully.');
        } catch (\Exception $e) {
            $this->dispatch('show-toast', type: 'error', message: 'Error: ' . $e->getMessage());
        }
    }

    public function resetForm()
    {
        $this->pick_up_location_id = '';
        $this->drop_off_location = '';
        $this->type = '';
        $this->status = '';
        $this->dropoffId = null;
        $this->resetValidation();
    }

    public function render()
    {
        $query = DropLocation::with('pickUpLocation');

        // Apply search filter
        if ($this->search) {
            $query->where('drop_off_location', 'like', '%' . $this->search . '%')
                ->orWhere('type', 'like', '%' . $this->search . '%')
                ->orWhere('status', 'like', '%' . $this->search . '%')
                ->orWhereHas('pickUpLocation', function ($q) {
                    $q->where('pickup_location', 'like', '%' . $this->search . '%');
                });
        }

        $dropOffs = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Get all pickup locations for modal
        $pickUpLocations = \App\Models\PickUpLocation::where('status', 'active')->orderBy('pickup_location')->get();

        return view('livewire.admin.drop-off.drop-off', compact('dropOffs', 'pickUpLocations'));
    }
}