<?php

namespace App\Livewire\Admin\Car;

use App\Models\CarDetails;
use Livewire\Component;
use Livewire\WithPagination;

class Car extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        try {
            CarDetails::findOrFail($id)->delete();
            $this->dispatch('show-toast', type: 'success', message: 'Car Details deleted successfully.');
        } catch (\Exception $e) {
            $this->dispatch('show-toast', type: 'error', message: 'Error: ' . $e->getMessage());
        }
    }


    public function render()
    {
        $query = CarDetails::query(); // ✅ Query Builder

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('model_variant', 'like', '%' . $this->search . '%');
            });
        }

        $cars = $query
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.car.car', compact('cars'));
    }
}
