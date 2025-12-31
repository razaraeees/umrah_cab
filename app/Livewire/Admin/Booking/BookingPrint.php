<?php

namespace App\Livewire\Admin\Booking;

use App\Models\Bookings;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class BookingPrint extends Component
{
    public $search = '';
    public $dateFilter = '';
    public $startDate = '';
    public $endDate = '';


    public function mount($filters = [])
    {
        $this->search = $filters['search'] ?? '';
        $this->dateFilter = $filters['dateFilter'] ?? '';
        $this->startDate = $filters['startDate'] ?? '';
        $this->endDate = $filters['endDate'] ?? '';
    }

    public function render()
    {
        $filters = [
            'search' => $this->search,
            'date_filter' => $this->dateFilter,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
        ];

        $bookings = Bookings::with(['pickupLocation', 'dropoffLocation', 'vehicle', 'additionalServices'])
            ->filter($filters)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('livewire.admin.booking.booking-print', compact('bookings'));
    }
}
