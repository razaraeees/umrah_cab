<?php

namespace App\Livewire\Admin\Car;

use App\Models\CarDetails;
use Livewire\Component;

class Edit extends Component
{
    public $carId;

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

    public function mount($carId)
    {
        $this->carId = $carId;
        $car = CarDetails::findOrFail($carId);

        $this->name = $car->name;
        $this->model_variant = $car->model_variant;
        $this->color = $car->color;
        $this->door = $car->door;
        $this->bag_capacity = $car->bag_capacity;
        $this->registration_number = $car->registration_number;
        $this->year = $car->year;
        $this->seating_capacity = $car->seating_capacity;
        $this->fuel_type = $car->fuel_type;
        $this->car_type = $car->car_type;
        $this->air_condition = $car->air_condition ? '1' : '0';
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'model_variant' => 'required|string|max:255',
            'color' => 'required|string|max:100',
            'door' => 'nullable|string|max:50',
            'bag_capacity' => 'nullable|string|max:50',
            'registration_number' => 'required|string|max:255|unique:car_details,registration_number,' . $this->carId,
            'year' => 'nullable|digits:4',
            'seating_capacity' => 'required|integer|min:1',
            'fuel_type' => 'nullable|string|max:50',
            'car_type' => 'nullable|string|max:50',
            'air_condition' => 'nullable|boolean',
        ];
    }

    public function update()
    {
        $this->validate();

        CarDetails::where('id', $this->carId)->update([
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

        $this->dispatch('show-toast', type: 'success', message: 'Car updated successfully.');

        return redirect()->route('car-detail.index');
    }

    public function render()
    {
        return view('livewire.admin.car.edit');
    }
}
