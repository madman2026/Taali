<?php

namespace Modules\User\Livewire\User;

use App\Contracts\HasNotifableComponent;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Media\Enums\MediaTypeEnum;
use Modules\User\Contracts\UpdateUserData;
use Modules\User\Services\UserService;

#[Layout('components.layouts.master')]
#[Title('Update User')]
class UpdateUser extends Component
{
    use WithFileUploads , HasNotifableComponent;

    public string $email;

    public string $name;

    #[Validate('nullable|image|mimes:jpeg,jpg,png|max:5000')]
    public $uploadedImage;

    public string $existingImagePath = '';

    protected UserService $service;

    public function boot(UserService $service): void
    {
        $this->service = $service;
    }

    public function mount()
    {
        $user = auth('web')->user();
        $this->email = $user->email;
        $this->name = $user->name;
        $this->existingImagePath = $user->avatar?->path ?? '';
    }

    public function updateUser()
    {
        $this->validate([
            'email' => 'required|email|unique:users,email,'.auth('web')->id(),
            'name' => 'required|string|max:255',
            'uploadedImage' => 'nullable|image|mimes:jpeg,jpg,png|max:5000',
        ]);

        $user = Auth::user();

        // Handle Image Upload
        if ($this->uploadedImage) {

            // Delete old image if exists
            if ($user->avatar) {
                $user->avatar->delete();
            }

            // Store new
            $path = $this->uploadedImage->store('profile-pictures', 'public');

            // Create new image record
            $userImage = $user->media()->create([
                'path' => $path,
                'type' => MediaTypeEnum::IMAGE,
            ]);
        }

        // Update user basic fields
        $data = new UpdateUserData(
            $this->email,
            $this->name
        );

        $response = $this->service->updateUser($data);

        if ($response->status) {
            $this->success(title: __('success'), message: __('Update Successful'));
        } else {
            $this->error(title: __('error'), message: $response->message ?? __('Update Failed'));
        }
    }

    public function render()
    {
        return view('user::livewire.user.update-user');
    }
}
