<?php

namespace Modules\User\Livewire\User;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Settings extends Component
{

    public $theme;
    public $language;
    public $font_size;

    public function mount()
    {
        $user = Auth::user();

        $this->theme = $user->getSetting('theme', 'light');
        $this->language = $user->getSetting('language', 'fa');
        $this->font_size = $user->getSetting('font_size', 'medium');
    }

    public function updated($propertyName)
    {
        $user = Auth::user();
        $user->setSetting($propertyName, $this->$propertyName);
    }

    public function render()
    {
        return view('user::livewire.user.settings');
    }
}


