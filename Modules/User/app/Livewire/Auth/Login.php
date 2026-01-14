<?php

namespace Modules\User\Livewire\Auth;

use Devrabiul\ToastMagic\Facades\ToastMagic;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Modules\User\Contracts\LoginData;
use Modules\User\Services\AuthService;

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
        if (! $result->status) {
            throw ValidationException::withMessages([
                'email' => __($result->message),
            ]);
        }

        $this->dispatch('toastMagic' , status: 'success', title: __('Login Successful'));
        $this->redirectRoute('home');
    }
}
