<?php

namespace App\Livewire\Admin\Components;

use Livewire\Component;

class Breadcrumbs extends Component
{

    public $title = "";
    public $bredcrumb1 = "";
    public $bredcrumb2 = "";

    public function render()
    {
        return view('livewire.admin.components.breadcrumbs');
    }
}
