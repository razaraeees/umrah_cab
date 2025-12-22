<?php

namespace App\Livewire\Admin\Cities;

use App\Models\Cities;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\City;

class CitiesIndex extends Component
{
    use WithPagination;

    public $search;
    public $perPage = 10;
    
    // Modal properties
    public $showModal = false;
    public $editMode = false;
    public $cityId;
    public $name;
    public $status = 'active';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openModal()
    {
        $this->reset(['cityId', 'name', 'status', 'editMode']);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['cityId', 'name', 'status', 'editMode']);
    }

    public function edit($id)
    {
        $city = Cities::findOrFail($id);

        $this->cityId = $id;
        $this->name = $city->name;
        $this->status = $city->status ? '1' : '0'; // Convert boolean to string for select

        $this->editMode = true;
        $this->showModal = true;
    }

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean'
        ]);

        

        try {
            if ($this->editMode) {
                $city = Cities::findOrFail($this->cityId);
                $city->update($validated);
                $this->dispatch('show-toast', type: 'success', message: 'City updated successfully.');
            } else {
                Cities::create($validated);
                $this->dispatch('show-toast', type: 'success', message: 'City created successfully.');
            }

            $this->closeModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Something went wrong!');
        }
    }

    public function delete($id)
    {
        $city = Cities::findOrFail($id);
        $city->delete();

        $this->dispatch('show-toast', type: 'success', message: 'City Deleted successfully.');

    }

    public function render()
    {
        $query = Cities::orderBy('created_at', 'desc');

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        $cities = $query->paginate($this->perPage);

        return view('livewire.admin.cities.cities-index', [
            'cities' => $cities
        ]);
    }
}
