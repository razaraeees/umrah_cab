<?php

namespace App\Livewire\Admin\PickUps;

use Livewire\Component;

class PickUp extends Component
{
    public $search = '';

    public function render()
    {
        return view('livewire.admin.pick-ups.pick-up');
    }
}
