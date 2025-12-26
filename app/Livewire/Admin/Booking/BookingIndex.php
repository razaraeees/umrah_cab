<?php

namespace App\Livewire\Admin\Booking;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Bookings;

class BookingIndex extends Component
{
    use WithPagination;

    public $search = '';
    protected $paginationTheme = 'bootstrap';

    // Ye zaruri hai taake search update hone par page reset ho jaye
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $bookings = Bookings::with(['pickupLocation', 'dropoffLocation', 'vehicle'])
            ->when($this->search, function ($query) {
                $query->where('guest_name', 'like', '%' . $this->search . '%')
                    ->orWhere('guest_phone', 'like', '%' . $this->search . '%')
                    ->orWhereHas('vehicle', function($q){
                        $q->where('vehicle_name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('pickupLocation', function($q){
                        $q->where('pickup_location_name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('dropoffLocation', function($q){
                        $q->where('dropoff_location_name', 'like', '%' . $this->search . '%');
                    });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.booking.booking-index', compact('bookings'));
    }

    public function delete($id)
    {
        $booking = Bookings::findOrFail($id);
        $booking->delete();
        $this->dispatch('show-toast', type: 'success', message: 'Booking deleted successfully.');
    }
}
