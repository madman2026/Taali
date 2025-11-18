<?php

namespace Modules\User\Actions;

class ToggleStatusAction
{
    public function handle($user)
    {
        if (! $user->hasRole('admin|super-admin')) {
            abort(403);
        }
        $user->update(['is_active' => ! $user->is_active]);

        return $user;
    }
}
