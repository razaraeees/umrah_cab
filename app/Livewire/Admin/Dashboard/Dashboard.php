<?php

namespace App\Livewire\Admin\Dashboard;

use Livewire\Component;
use App\Models\Bookings;

class Dashboard extends Component
{
    public $startDate;
    public $endDate;

    public function mount()
    {
        $this->startDate = null;
        $this->endDate = null;
    }

    public function applyDateFilter()
    {
        // This will trigger the render method with updated dates
    }

    public function clearDateFilter()
    {
        $this->startDate = null;
        $this->endDate = null;
    }

    public function render()
    {
        $baseQuery = Bookings::query();

        if ($this->startDate) {
            $baseQuery->whereDate('pickup_date', '>=', $this->startDate);
        }

        if ($this->endDate) {
            $baseQuery->whereDate('pickup_date', '<=', $this->endDate);
        }

        $totalBookings = (clone $baseQuery)->count();

        $pickupBookings = (clone $baseQuery)
            ->where('booking_status', 'pickup')
            ->count();

        $dropoffBookings = (clone $baseQuery)
            ->where('booking_status', 'dropoff')
            ->count();

        $cancelledBookings = (clone $baseQuery)
            ->where('booking_status', 'cancelled')
            ->count();

        $totalRevenue = (clone $baseQuery)->where('booking_status', '=', 'dropoff')->sum('total_amount');

        $totalDriverEarnings = $totalRevenue * 0.8;
        $totalAdminEarnings = $totalRevenue * 0.2;

        return view('livewire.admin.dashboard.dashboard', compact(
            'totalBookings',
            'pickupBookings',
            'dropoffBookings',
            'cancelledBookings',
            'totalRevenue',
            'totalDriverEarnings',
            'totalAdminEarnings'
        ));
    }
}
