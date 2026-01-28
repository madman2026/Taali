<?php

namespace Modules\Admin\Livewire;

use App\Contracts\HasNotifableComponent;
use Livewire\Component;

class AdminDashboard extends Component
{
    use HasNotifableComponent;

    public function render()
    {
        return view('admin::livewire.admin-dashboard');
    }
}
