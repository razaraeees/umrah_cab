<?php

namespace App\Livewire\Admin\Accounts;

use App\Models\Bookings;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Driver;

class DriverIndex extends Component
{
    use WithPagination;

    public $search;
    public $showDetailsModal = false;
    public $selectedDriver = null;
    public $driverBookings = [];

    public function showDetails($driverId)
    {
        $this->selectedDriver = Driver::with(['carDetails', 'bookings' => function($query) {
            $query->where('booking_status', '!=', 'cancelled')->latest();
        }])->find($driverId);
        
        $this->driverBookings = $this->selectedDriver->bookings;
        $this->showDetailsModal = true;
    }

    public function closeDetailsModal()
    {
        $this->showDetailsModal = false;
        $this->selectedDriver = null;
        $this->driverBookings = [];
    }

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
        $drivers = Driver::with(['carDetails', 'bookings' => function($query) {
                $query->where('booking_status', '=', 'dropoff');
            }])
            ->whereHas('bookings', function($query) {
                $query->where('booking_status', '=', 'dropoff');
            })
            ->when($this->search, function($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhereHas('carDetails', function($q) {
                          $q->where('name', 'like', '%' . $this->search . '%');
                      });
            })
            ->latest()
            ->paginate(20);

        return view('livewire.admin.accounts.driver-index', compact('drivers'));
    }
}
