<?php

namespace Modules\User\Services;

use App\Contracts\BaseService;
use App\Contracts\ServiceResponse;
use Modules\User\Actions\LoginAction;
use Modules\User\Actions\RegisterAction;
use Modules\User\Contracts\LoginData;
use Modules\User\Contracts\RegisterData;
use Modules\User\Events\Auth\Registered;

final class AuthService extends BaseService
{
    public function __construct(
        private readonly LoginAction $loginAction,
        private readonly RegisterAction $registerAction
    ) {}

    public function login(LoginData $loginData): ServiceResponse
    {
        return $this->execute(function () use ($loginData) {
            $user = $this->loginAction->handle($loginData);

            return $user;
        });
    }

    public function register(RegisterData $registerData): ServiceResponse
    {
        return $this->execute(function () use ($registerData) {
            $user = $this->registerAction->handle($registerData);
            event(new Registered($user));

            return $user;
        });
    }
}
