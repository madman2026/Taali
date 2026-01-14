<?php

namespace Modules\User\Actions;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Modules\User\Contracts\LoginData;
use Modules\User\Models\User;

final class LoginAction
{
    public function __construct(
        protected Request $request,
        protected Application $app,
        protected int $maxAttempts = 5,
        protected int $decayMinutes = 15,
    ) {}

    protected function throttleKey(string $email): string
    {
        $ip = request()->ip() ?? 'unknown';

        return Str::lower($email).'|'.$ip;
    }

    public function handle(LoginData $data): ?Authenticatable
    {
        $key = $this->throttleKey($data->email);

        if (RateLimiter::tooManyAttempts($key, $this->maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'email' => ["Too Many Attempt . please try {$seconds} seconds"],
            ]);
        }
        $user = User::whereEmail($data->email)->first();
        if (Hash::check($data->password, $user->password)) {
            Auth::guard('web')->login($user , true);
            RateLimiter::clear($key);

            return Auth::user();
        }
        RateLimiter::hit($key, $this->decayMinutes * 60);

        throw ValidationException::withMessages([
            'email' => ['Invalid Informations!'],
        ]);
    }
}
