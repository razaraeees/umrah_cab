<?php

namespace App\Livewire\Admin\Car;

use App\Models\CarDetails;
use Livewire\Component;

class Create extends Component
{
    public $name;
    public $model_variant;
    public $color;
    public $door;
    public $bag_capacity;
    public $registration_number;
    public $year;
    public $seating_capacity;
    public $fuel_type;
    public $car_type;
    public $air_condition;

    protected $rules = [
        'name' => 'required|string|max:255',
        'model_variant' => 'required|string|max:255',
        'color' => 'required|string|max:100',
        'door' => 'nullable|string|max:50',
        'bag_capacity' => 'nullable|string|max:50',
        'registration_number' => 'required|string|max:255|unique:car_details,registration_number',
        'year' => 'nullable|digits:4',
        'seating_capacity' => 'required|integer|min:1',
        'fuel_type' => 'nullable|string|max:50',
        'car_type' => 'nullable|string|max:50',
        'air_condition' => 'nullable|boolean',
    ];

    public function save()
    {
        $this->validate();

        CarDetails::create([
            'name' => $this->name,
            'model_variant' => $this->model_variant,
            'color' => $this->color,
            'door' => $this->door,
            'bag_capacity' => $this->bag_capacity,
            'registration_number' => $this->registration_number,
            'year' => $this->year,
            'seating_capacity' => $this->seating_capacity,
            'fuel_type' => $this->fuel_type,
            'car_type' => $this->car_type,
            'air_condition' => $this->air_condition,
        ]);

        $this->dispatch('show-toast', type: 'success', message: 'Car created successfully.');

        return redirect()->route('car-detail.index');
    }

    public function render()
    {
        return view('livewire.admin.car.create');
    }
}
