<?php

namespace Modules\User\Livewire\Auth;

use App\Contracts\HasNotifableComponent;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Modules\User\Contracts\RegisterData;
use Modules\User\Services\AuthService;

#[Layout('user::components.layouts.auth-master')]
#[Title('Register')]
class Register extends Component
{
    use HasNotifableComponent;

    #[Validate('required|email|unique:users,email')]
    public ?string $email;

    #[Validate('required|string|unique:users,name')]
    public ?string $name;

    #[Validate('required|confirmed|string|min:6')]
    public ?string $password;

    public ?string $password_confirmation;

    protected AuthService $service;

    public function boot(AuthService $service)
    {
        $this->service = $service;
    }

    public function render()
    {
        return view('user::livewire.auth.register');
    }

    public function register()
    {
        $result = $this->service->register(RegisterData::fromArray($this->validate()));
        if (! $result->status) {
            throw ValidationException::withMessages([
                'email' => __($result->message),
            ]);
        }
        $this->success(__('Register Successful'));

        return redirect()->intended(route('home'));
    }
}
