<?php

namespace App\Livewire\Admin\Accounts;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Driver;
use Barryvdh\DomPDF\Facade\Pdf;

class DriverDetails extends Component
{
    use WithPagination;

    public $driverId;
    public $driver;
    public $search = '';
    public $perPage = 10;
    public $dateFilter = '';
    public $startDate = '';
    public $endDate = '';

    protected $paginationTheme = 'bootstrap';

    public function mount($id)
    {
        $this->driverId = $id;
        $this->loadDriver();
    }

    public function loadDriver()
    {
        $this->driver = Driver::with(['carDetails', 'bookings' => function ($query) {
            $query->where('booking_status', '=', 'dropoff')->with('additionalServices');
        }])->find($this->driverId);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingDateFilter()
    {
        $this->resetPage();
    }

    public function updatingStartDate()
    {
        $this->resetPage();
    }

    public function updatingEndDate()
    {
        $this->resetPage();
    }

    public function applyDateRange()
    {
        $this->resetPage();
        $this->dateFilter = '';
    }

    public function clearDateRange()
    {
        $this->startDate = '';
        $this->endDate = '';
        $this->dateFilter = '';
        $this->resetPage();
    }

    private function filteredBookingsQuery()
    {
        $query = $this->driver->bookings()
            ->where('booking_status', 'dropoff')
            ->with('additionalServices');

        if ($this->startDate) {
            $query->whereDate('pickup_date', '>=', $this->startDate);
        }

        if ($this->endDate) {
            $query->whereDate('pickup_date', '<=', $this->endDate);
        }

        return $query;
    }


    public function generatePDF()
    {
        $allBookings = $this->filteredBookingsQuery()
            ->orderBy('pickup_date', 'desc')
            ->get();

        $totalRides = $allBookings->count();
        $totalDriverEarnings = $allBookings->sum('total_amount') * 0.8;
        $totalAdminEarnings = $allBookings->sum('total_amount') * 0.2;

        $driver = $this->driver;

        $pdf = Pdf::loadView(
            'admin.account.driver_pdf',
            compact(
                'driver',
                'allBookings',
                'totalRides',
                'totalDriverEarnings',
                'totalAdminEarnings'
            )
        );

        return response()->streamDownload(
            fn() => print($pdf->output()),
            'driver-details-' . $driver->name . '-' . now()->format('Y-m-d') . '.pdf'
        );
    }


    public function render()
    {
        $bookings = $this->filteredBookingsQuery()
            ->orderBy('pickup_date', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.accounts.driver-details', compact('bookings'));
    }
}
