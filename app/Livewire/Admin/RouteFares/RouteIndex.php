<?php

namespace App\Livewire\Admin\RouteFares;

use Livewire\Component;
use App\Models\RouteFares;
use Livewire\WithPagination;

class RouteIndex extends Component
{
    use WithPagination;

    public $search;
    public $perPage = 10;

    public function updatingSearch(){
        $this->resetPage();
    }

    public function delete($id)
    {
        $routeFare = RouteFares::findOrFail($id);
        $routeFare->delete();

        session()->flash('success', 'Route fare deleted successfully!');
    }

    public function render()
    {
        $query = RouteFares::with(['pickupLocation', 'dropoffLocation', 'vehicle'])
            ->orderBy('created_at', 'desc');

        if ($this->search) {
            $query->where(function($q) {
                $q->whereHas('pickupLocation', function($subQuery) {
                    $subQuery->where('pickup_location', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('dropoffLocation', function($subQuery) {
                    $subQuery->where('drop_off_location', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('vehicle', function($subQuery) {
                    $subQuery->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhere('amount', 'like', '%' . $this->search . '%')
                ->orWhere('status', 'like', '%' . $this->search . '%');
            });
        }

        $routeFares = $query->paginate($this->perPage);
        
        return view('livewire.admin.route-fares.route-index', [
            'routeFares' => $routeFares
        ]);
    }
}
