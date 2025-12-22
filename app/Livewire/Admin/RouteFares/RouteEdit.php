<?php

namespace App\Livewire\Admin\RouteFares;

use Livewire\Component;
use App\Models\RouteFares;
use App\Models\PickUpLocation;
use App\Models\DropLocation;
use App\Models\CarDetails;

class RouteEdit extends Component
{
    public $routeFare;
    public $pickupId;
    public $dropoffId;
    public $vehicleId;
    public $amount;
    public $start_date;
    public $end_date;
    public $route_status;
    
    public $pickupLocations;
    public $dropoffLocations;
    public $vehicles;

    public function mount($id)
    {
        $this->routeFare = RouteFares::findOrFail($id);
        
        $this->pickupId = $this->routeFare->pickup_id;
        $this->dropoffId = $this->routeFare->dropoff_id;
        $this->vehicleId = $this->routeFare->vehicle_id;
        $this->amount = $this->routeFare->amount;
        $this->start_date = $this->routeFare->start_date->format('Y-m-d');
        $this->end_date = $this->routeFare->end_date->format('Y-m-d');
        $this->route_status = $this->routeFare->status;

        $this->pickupLocations = PickUpLocation::where('status', 'active')->get();
        $this->vehicles = CarDetails::orderBy('name', 'asc')->get();
        
        if ($this->pickupId) {
            $this->dropoffLocations = DropLocation::where('pick_up_location_id', $this->pickupId)
                ->where('status', 'active')
                ->get();
        } else {
            $this->dropoffLocations = collect();
        }
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

    public function update()
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

        $this->routeFare->update([
            'pickup_id' => $this->pickupId,
            'dropoff_id' => $this->dropoffId,
            'vehicle_id' => $this->vehicleId,
            'amount' => $this->amount,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => $this->route_status
        ]);

        $this->dispatch('show-toast', type: 'success', message: 'Route fare updated successfully!');
        return redirect()->route('routefares.index');
    }

    public function render()
    {
        return view('livewire.admin.route-fares.route-edit');
    }
}
