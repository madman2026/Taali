<?php

namespace Modules\User\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\User\Contracts\UpdateUserData;

final class UpdateUserAction
{
    public function handle(UpdateUserData $userData)
    {
        $user = Auth::user();

        $user->update($userData->toArray());

        return $user;
    }
}
