<?php

namespace Modules\User\Livewire\Auth;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Modules\User\Contracts\LoginData;
use Modules\User\Services\AuthService;
use Illuminate\Validation\ValidationException;

#[Layout('user::components.layouts.auth-master')]
#[Title('Login')]
class Login extends Component
{
    #[Validate('required|email|exists:users,email')]
    public string $email = '';

    #[Validate('required|string|min:6')]
    public string $password = '';

    protected AuthService $service;

    public function boot(AuthService $service)
    {
        $this->service = $service;
    }

    public function render()
    {
        return view('user::livewire.auth.login');
    }

    public function login()
    {

        $result = $this->service->login(LoginData::fromArray($this->validate()));
        if (!$result->status) {
            throw ValidationException::withMessages([
                'email' => __($result->message),
            ]);
        }

        Toaster::success(__('Login Successful'));
        $this->redirectRoute('home');
    }

    public function foo()
    {
        Toaster::success(__('Login Successful'));
    }
}
