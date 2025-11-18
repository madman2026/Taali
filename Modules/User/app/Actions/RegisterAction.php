<?php

namespace Modules\User\Actions;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\User\Contracts\RegisterData;
use Modules\User\Models\User;

final class RegisterAction
{
    public function handle(RegisterData $data): ?Authenticatable
    {
        dd($data);
        $user = User::create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => Hash::make($data->password),
        ]);
        $user->assignRole('user');
        Auth::login($user, $data->remember);

        return $user;
    }
}
