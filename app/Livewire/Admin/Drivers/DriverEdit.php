<?php

namespace App\Livewire\Admin\Drivers;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Driver;
use App\Models\CarDetails;

class DriverEdit extends Component
{
    use WithFileUploads;

    public $driver;
    public $name;
    public $phone;
    public $email;
    public $driver_status = 'active';
    public $car_id;
    public $rc_copy;
    public $insurance_copy;
    public $driving_license;
    public $dl_expiry;
    public $car_image;
    public $driver_image;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:50',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:drivers,email,' . $this->driver->id,
            'driver_status' => 'required|in:active,inactive',
            'car_id' => 'nullable|exists:car_details,id',
            'dl_expiry' => 'nullable|date',
            'driver_image' => 'nullable|image|max:2048',
            'car_image' => 'nullable|image|max:2048',
            'rc_copy' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'insurance_copy' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'driving_license' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ];
    }


    // Bypass Livewire's preview_mimes check using ignore hook
    protected $validationAttributes = [
        'rc_copy' => 'RC copy',
        'insurance_copy' => 'insurance copy',
        'driving_license' => 'driving license',
        'car_image' => 'car image',
        'driver_image' => 'driver image',
    ];

    public function mount($driver)
    {
        $this->driver = $driver;
        $this->name = $driver->name;
        $this->phone = $driver->phone;
        $this->email = $driver->email;
        $this->driver_status = $driver->status;
        $this->car_id = $driver->car_id;
        $this->dl_expiry = $driver->dl_expiry;
    }

    // Handle file updates without triggering preview_mimes error
    public function updatedRcCopy()
    {
        $this->validateOnly('rc_copy');
    }

    public function updatedInsuranceCopy()
    {
        $this->validateOnly('insurance_copy');
    }

    public function updatedDrivingLicense()
    {
        $this->validateOnly('driving_license');
    }

    public function updatedCarImage()
    {
        $this->validateOnly('car_image');
    }

    public function updatedDriverImage()
    {
        $this->validateOnly('driver_image');
    }

    // Remove methods for file uploads
    public function removeRcCopy()
    {
        $this->rc_copy = null;
    }

    public function removeInsuranceCopy()
    {
        $this->insurance_copy = null;
    }

    public function removeDrivingLicense()
    {
        $this->driving_license = null;
    }

    public function removeDriverImage()
    {
        $this->driver_image = null;
    }

    public function removeCarImage()
    {
        $this->car_image = null;
    }

    public function removeExistingRcCopy()
    {
        $this->driver->rc_copy = null;
        $this->driver->save();
        $this->dispatch('show-toast', type: 'success', message: 'Delete Rc successfully!');

    }

    public function removeExistingInsuranceCopy()
    {
        $this->driver->insurance_copy = null;
        $this->driver->save();

        $this->dispatch('show-toast', type: 'success', message: 'Delete Insurance Copy successfully!');

    }

    public function removeExistingDrivingLicense()
    {
        $this->driver->driving_license = null;
        $this->driver->save();

        $this->dispatch('show-toast', type: 'success', message: 'Delete Driving license successfully!');

    }

    public function update()
    {
        $this->validate();

        $driverData = [
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'status' => $this->driver_status,
            'car_id' => $this->car_id,
            'dl_expiry' => $this->dl_expiry,
        ];

        // Handle file uploads
        if ($this->rc_copy) {
            $driverData['rc_copy'] = $this->rc_copy->store('driver_documents', 'public');
        }
        if ($this->insurance_copy) {
            $driverData['insurance_copy'] = $this->insurance_copy->store('driver_documents', 'public');
        }
        if ($this->driving_license) {
            $driverData['driving_license'] = $this->driving_license->store('driver_documents', 'public');
        }
        if ($this->car_image) {
            $driverData['car_image'] = $this->car_image->store('driver_images', 'public');
        }
        if ($this->driver_image) {
            $driverData['driver_image'] = $this->driver_image->store('driver_images', 'public');
        }

        $this->driver->update($driverData);

        $this->dispatch('show-toast', type: 'success', message: 'Driver updated successfully!');

        return redirect()->route('driver-detail.index');
    }

    public function render()
    {
        $cars = CarDetails::all();
        return view('livewire.admin.drivers.driver-edit', compact('cars'));
    }
}
