<?php

namespace Modules\User\View\Components\User\Dashboard;

use Illuminate\View\Component;
use Illuminate\View\View;

class Link extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct() {}

    /**
     * Get the view/contents that represent the component.
     */
    public function render(): View|string
    {
        return view('user::components.user.dashboard-link');
    }
}
