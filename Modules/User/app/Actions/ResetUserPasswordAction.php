<?php

namespace Modules\User\Actions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

final class ResetUserPasswordAction
{
    public function handle(array $data): bool
    {
        $user = Auth::user();
        $user->update([
            'password' => Hash::make($data['newPassword']),
        ]);

        return true;
    }
}
