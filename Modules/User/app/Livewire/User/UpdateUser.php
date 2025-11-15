<?php

namespace Modules\User\Livewire\User;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Masmerise\Toaster\Toaster;
use Modules\Media\Enums\MediaTypeEnum;
use Modules\User\Contracts\UpdateUserData;
use Modules\User\Services\UserService;

#[Layout('user::components.layouts.master')]
#[Title('Update User')]
class UpdateUser extends Component
{
    use WithFileUploads;

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
        $user = auth()->user();
        $this->email = $user->email;
        $this->name = $user->name;
        $this->existingImagePath = $user->image->first()?->path ?? '';
    }

    public function updateUser()
    {
        $this->validate([
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'name' => 'required|string|max:255',
        ]);

        if ($this->uploadedImage) {
            $path = $this->uploadedImage->store('profile-pictures', 'public');
        }

        $userImage = Auth::user()->image()->createOrFirst(
            [
                'path' => $this->existingImagePath
            ]
        );
        if (isset($path))
            $userImage->path = $path;
        $userImage->type = MediaTypeEnum::IMAGE;
        $userImage->mime_type = $this->uploadedImage ? $this->uploadedImage->getMimeType() : $userImage->mime_type;
        $userImage->save();

        $data = new UpdateUserData(
            $this->email,
            $this->name
        );

        $response = $this->service->updateUser($data);

        if ($response->status) {
            Toaster::success(__('Update Successful'));
        } else {
            Toaster::error($response->message ?? __('Update Failed'));
        }
    }

    public function render()
    {
        return view('user::livewire.user.update-user');
    }
}
