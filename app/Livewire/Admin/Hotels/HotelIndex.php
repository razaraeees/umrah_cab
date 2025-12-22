<?php

namespace App\Livewire\Admin\Hotels;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Hotel;
use App\Models\City;

class HotelIndex extends Component
{
    use WithPagination;

    public $search;
    public $perPage = 10;
    public $selectedCity = null;
    
    // Modal properties
    public $showModal = false;
    public $editMode = false;
    public $hotelId;
    public $name;
    public $cityId;
    public $status = 'active';
    public $cities;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->cities = City::where('status', true)->orderBy('name', 'asc')->get();
    }

    public function openModal()
    {
        $this->reset(['hotelId', 'name', 'cityId', 'status', 'editMode']);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['hotelId', 'name', 'cityId', 'status', 'editMode']);
    }

    public function selectCity($id)
    {
        $this->selectedCity = $id;
        $this->search = '';
        $this->resetPage();
    }

    public function clearCityFilter()
    {
        $this->selectedCity = null;
        $this->resetPage();
    }

    public function edit($id)
    {
        $hotel = Hotel::findOrFail($id);

        $this->hotelId = $id;
        $this->name = $hotel->name;
        $this->cityId = $hotel->city_id;
        $this->status = $hotel->status ? '1' : '0';

        $this->editMode = true;
        $this->showModal = true;
    }

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'cityId' => 'required|exists:cities,id',
            'status' => 'required|boolean'
        ]);

        // Map cityId to city_id for database
        $validated['city_id'] = $validated['cityId'];
        unset($validated['cityId']);

        try {
            if ($this->editMode) {
                $hotel = Hotel::findOrFail($this->hotelId);
                $hotel->update($validated);
                $this->dispatch('show-toast', type: 'success', message: 'Hotel updated successfully.');
            } else {
                Hotel::create($validated);
                $this->dispatch('show-toast', type: 'success', message: 'Hotel created successfully.');
            }

            $this->closeModal();
        } catch (\Exception $e) {
            // session()->flash('error', 'Something went wrong!');
            $this->dispatch('show-toast', type: 'error', message: 'Error: ' . $e->getMessage());

        }
    }

    public function delete($id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->delete();

        $this->dispatch('show-toast', type: 'success', message: 'Hotel deleted successfully.');
    }

    public function render()
    {
        $query = Hotel::with('city')->orderBy('created_at', 'desc');

        // Apply search filter
        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%')
                  ->orWhereHas('city', function($subQuery) {
                      $subQuery->where('name', 'like', '%' . $this->search . '%');
                  });
        }

        // Apply city filter
        if ($this->selectedCity) {
            $query->where('city_id', $this->selectedCity);
        }

        $hotels = $query->paginate($this->perPage);

        return view('livewire.admin.hotels.hotel-index', [
            'hotels' => $hotels
        ]);
    }
}
