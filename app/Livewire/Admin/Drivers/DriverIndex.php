<?php

namespace App\Livewire\Admin\Drivers;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Driver;

class DriverIndex extends Component
{
    use WithPagination;

    public $search;
    public $perPage = 10;

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch(){
        $this->resetPage();
    }

    public function delete($id){

        $delete = Driver::find($id);
        $delete->delete();

        $this->dispatch('show-toast', type: 'success', message: 'Driver deleted successfully!');
    }

    public function render()
    {
        $drivers = Driver::with('carDetails')
            ->when($this->search, function($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhereHas('carDetails', function($q) {
                          $q->where('name', 'like', '%' . $this->search . '%');
                      });
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.drivers.driver-index', compact('drivers'));
    }
}
