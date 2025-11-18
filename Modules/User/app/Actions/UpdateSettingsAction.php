<?php

namespace Modules\User\Actions;

use Illuminate\Support\Facades\Auth;

class UpdateSettingsAction
{
    public function handle(array $settings)
    {
        $user = Auth::user();
        $user->update(['settings' => json_encode($settings)]);

        return $user;
    }
}
