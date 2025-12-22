<?php

namespace App\Livewire\Admin\RouteFares;

use Livewire\Component;
use App\Models\RouteFares;
use App\Models\PickUpLocation;
use App\Models\DropLocation;
use App\Models\CarDetails;

class RouteCreate extends Component
{
    public $pickupId;
    public $dropoffId;
    public $vehicleId;
    public $amount;
    public $start_date;
    public $end_date;
    public $route_status = 'active';

    public $pickupLocations = [];
    public $dropoffLocations = [];
    public $vehicles = [];

    public function mount()
    {
        $this->pickupLocations = PickUpLocation::where('status', 'active')->get();
        $this->dropoffLocations = collect();
        $this->vehicles = CarDetails::orderBy('name', 'asc')->get();
    }

    public function updatedPickupId($value)
    {
        $this->dropoffId = null;
        if ($value) {
            $this->dropoffLocations = DropLocation::where('pick_up_location_id', $value)
                ->where('status', 'active')
                ->get();
        } else {
            $this->dropoffLocations = collect();
        }
    }

    public function save()
    {
        $this->validate([
            'pickupId' => 'required|exists:pick_up_locations,id',
            'dropoffId' => 'required|exists:drop_locations,id',
            'vehicleId' => 'required|exists:car_details,id',
            'amount' => 'required|numeric|min:0',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'route_status' => 'required|in:active,inactive'
        ]);

        RouteFares::create([
            'pickup_id' => $this->pickupId,
            'dropoff_id' => $this->dropoffId,
            'vehicle_id' => $this->vehicleId,
            'amount' => $this->amount,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => $this->route_status
        ]);

        $this->dispatch('show-toast', type: 'success', message: 'Routes & fares created successfully!');
        $this->reset([
            'pickupId',
            'dropoffId',
            'vehicleId',
            'amount',
            'start_date',
            'end_date',
            'route_status',
        ]);
    }

    public function render()
    {
        return view('livewire.admin.route-fares.route-create');
    }
}
