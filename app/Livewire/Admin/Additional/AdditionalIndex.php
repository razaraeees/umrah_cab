<?php

namespace App\Livewire\Admin\Additional;

use App\Models\AdditionalService;
use Livewire\Component;
use Livewire\WithPagination;

class AdditionalIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $editMode = false;
    public $size = 'md';
    public $showHeader = true;

    public $service_id;
    public $services;
    public $charges_type = 'percentage';
    public $charge_value;
    public $type;
    public $status = 'active';

    protected $rules = [
        'services' => 'required|string|max:255',
        'charges_type' => 'required|in:fixed,percentage',
        'charge_value' => 'required|numeric|min:0',
        'type' => 'nullable|string|max:255',
        'status' => 'required|in:active,inactive',
    ];

    protected $messages = [
        'services.required' => 'Service name is required',
        'charges_type.required' => 'Charges type is required',
        'charge_value.required' => 'Charge value is required',
        'charge_value.numeric' => 'Charge value must be a number',
        'charge_value.min' => 'Charge value must be at least 0',
    ];

    public function render()
    {
        $additionalServices = AdditionalService::query()
            ->when($this->search, function ($query) {
                $query->where('services', 'like', '%' . $this->search . '%')
                    ->orWhere('type', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.additional.additional-index', [
            'additionalServices' => $additionalServices
        ]);
    }

    public function openModal()
    {
        $this->resetValidation();
        $this->reset(['service_id', 'services', 'charges_type', 'charge_value', 'type', 'status']);
        $this->editMode = false;
        $this->showModal = true;
        $this->charges_type = 'percentage';
        $this->status = 'active';
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetValidation();
        $this->reset(['service_id', 'services', 'charges_type', 'charge_value', 'type', 'status']);
    }

    public function save()
    {
        $this->validate();

        AdditionalService::updateOrCreate(
            ['id' => $this->service_id],
            [
                'services' => $this->services,
                'charges_type' => $this->charges_type,
                'charge_value' => $this->charge_value,
                'type' => $this->type,
                'status' => $this->status,
            ]
        );

        $this->closeModal();
        $this->dispatch('success', $this->editMode ? 'Additional service updated successfully!' : 'Additional service added successfully!');
    }

    public function edit($id)
    {
        $service = AdditionalService::findOrFail($id);
        
        $this->service_id = $service->id;
        $this->services = $service->services;
        $this->charges_type = $service->charges_type;
        $this->charge_value = $service->charge_value;
        $this->type = $service->type;
        $this->status = strtolower($service->status);
        
        $this->editMode = true;
        $this->showModal = true;
    }

    public function delete($id)
    {
        $service = AdditionalService::findOrFail($id);
        $service->delete();
        $this->dispatch('success', 'Additional service deleted successfully!');
    }

    public function toggleStatus($id)
    {
        $service = AdditionalService::findOrFail($id);
        $service->status = strtolower($service->status) === 'active' ? 'inactive' : 'active';
        $service->save();
        $this->dispatch('success', 'Status updated successfully!');
    }
}
