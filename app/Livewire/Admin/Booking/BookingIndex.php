<?php

namespace App\Livewire\Admin\Booking;

use Livewire\Component;
use App\Models\Bookings;

class BookingIndex extends Component
{
    public $search = '';

    public function render()
    {
        $bookings = Bookings::with(['pickupLocation', 'dropoffLocation', 'vehicle'])
            ->when($this->search, function ($query) {
                $query->where('guest_name', 'like', '%' . $this->search . '%')
                    ->orWhere('guest_phone', 'like', '%' . $this->search . '%')
                    ->orWhere('vehicle_name', 'like', '%' . $this->search . '%')
                    ->orWhere('pickup_location_name', 'like', '%' . $this->search . '%')
                    ->orWhere('dropoff_location_name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.booking.booking-index', compact('bookings'));
    }

    public function delete($id)
    {
        $booking = Bookings::findOrFail($id);
        $booking->delete();
        
        session()->flash('message', 'Booking deleted successfully.');
    }
}
