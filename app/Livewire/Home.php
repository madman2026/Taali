<?php

namespace App\Livewire;

use App\Contracts\HasNotifableComponent;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.master')]
#[Title('Home')]
class Home extends Component
{
    use HasNotifableComponent;

    public function render()
    {
        return view('livewire.home');
    }
}
