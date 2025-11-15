<?php

namespace Modules\User\Actions;

use Illuminate\Support\Facades\Auth;

class DeleteUserAction
{
    public function handle()
    {
        $user = Auth::user();
        $user->delete();
        return true;
    }
}
