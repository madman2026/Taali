<?php

namespace Modules\User\Actions;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\User\Contracts\LoginData;

final class VerifyAction
{
    public function __construct(
        protected Request $request,
        protected Application $app,
        protected int $maxAttempts = 5,
        protected int $decayMinutes = 15,
    ) {}

    protected function throttleKey(string $email): string
    {
        $ip = $this->request->ip() ?? 'unknown';

        return Str::lower($email).'|'.$ip;
    }

    //    public function handle(LoginData $data): ?Authenticatable
    //    {

    //    }
}
