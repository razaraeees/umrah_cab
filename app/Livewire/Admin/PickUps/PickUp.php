<?php

namespace App\Livewire\Admin\PickUps;

use App\Models\PickUpLocation;
use Livewire\Component;
use Livewire\WithPagination;

class PickUp extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $showModal = false;
    public $editMode = false;
    public $pickupId;
    
    // Form fields
    public $pick_up_location = '';
    public $type = '';
    public $pickup_status = '';

    protected $rules = [
        'pick_up_location' => 'required|string|max:255',
        'type' => 'required|in:airport,hotel,city,other',
        'pickup_status' => 'required|in:active,inactive',
    ];

    protected $messages = [
        'pick_up_location.required' => 'Pick up location is required.',
        'type.required' => 'Type is required.',
        'pickup_status.required' => 'Status is required.',
    ];

    // Reset pagination when search changes
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openModal()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function edit($id)
    {
        $pickUp = PickUpLocation::findOrFail($id);
        
        $this->pickupId = $id;
        $this->pick_up_location = $pickUp->pickup_location;
        $this->type = $pickUp->type;
        $this->pickup_status = $pickUp->status;
        
        $this->editMode = true;
        $this->showModal = true;
    }

    public function save()
    {
        $validated = $this->validate();

        try {
            if ($this->editMode) {
                // Update existing record
                $pickUp = PickUpLocation::findOrFail($this->pickupId);
                $pickUp->update([
                    'pickup_location' => $validated['pick_up_location'],
                    'type' => $validated['type'],
                    'status' => $validated['pickup_status'],
                ]);
                
                session()->flash('message', 'Pick up location updated successfully.');
            } else {
                // Create new record
                PickUpLocation::create([
                    'pickup_location' => $validated['pick_up_location'],
                    'type' => $validated['type'],
                    'status' => $validated['pickup_status'],
                ]);
                
                session()->flash('message', 'Pick up location added successfully.');
            }

            $this->closeModal();
            
        } catch (\Exception $e) {
            session()->flash('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            PickUpLocation::findOrFail($id)->delete();
            session()->flash('message', 'Pick up location deleted successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete location.');
        }
    }

    public function resetForm()
    {
        $this->pick_up_location = '';
        $this->type = '';
        $this->pickup_status = '';
        $this->pickupId = null;
        $this->resetValidation();
    }

    public function render()
    {
        $pickUps = PickUpLocation::where(function($query) {
            if ($this->search) {
                $query->where('pickup_location', 'like', '%' . $this->search . '%')
                      ->orWhere('type', 'like', '%' . $this->search . '%')
                      ->orWhere('status', 'like', '%' . $this->search . '%');
            }
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        
        return view('livewire.admin.pick-ups.pick-up', compact('pickUps'));
    }
}