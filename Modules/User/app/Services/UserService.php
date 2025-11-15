<?php

namespace Modules\User\Services;

use App\Contracts\BaseService;
use App\Contracts\ServiceResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Modules\User\Actions\DeleteUserAction;
use Modules\User\Actions\ResetUserPasswordAction;
use Modules\User\Actions\ToggleStatusAction;
use Modules\User\Actions\UpdateSettingsAction;
use Modules\User\Actions\UpdateUserAction;
use Modules\User\Contracts\UpdateUserData;
use Modules\User\Models\User;

class UserService extends BaseService
{
    public function __construct(private UpdateUserAction $updateUserAction ,
                                private ResetUserPasswordAction $resetPassword ,
                                private DeleteUserAction $deleteUserAction ,
                                private UpdateSettingsAction $updateSettingsAction ,
                                private ToggleStatusAction $toggleStatusAction){}
    public function currentUser(): ServiceResponse
    {
        return $this->execute(fn() => Auth::user());
    }

    public function getUser(int $id): ServiceResponse
    {
        return $this->execute(fn() => User::findOrFail($id));
    }

    public function updateUser(UpdateUserData $userData): ServiceResponse
    {
        return $this->execute(function () use ($userData) {
            $this->updateUserAction->handle($userData);
        }, "Failed to update user", "User updated successfully");
    }

public function updatePassword(array $data): ServiceResponse
{
    return $this->execute(function () use ($data) {

        $user = Auth::user();

        if (!isset($data['password'], $data['newPassword'])) {
            throw ValidationException::withMessages([
                'password' => __('Missing required fields.')
            ]);
        }

        if (!Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'password' => __('The current password is incorrect.')
            ]);
        }

        if (Hash::check($data['newPassword'], $user->password)) {
            throw ValidationException::withMessages([
                'newPassword' => __('The new password cannot be the same as the current password.')
            ]);
        }

        return $this->resetPassword->handle($data);

    }, __('Failed to update password'), __('Password updated successfully'));
}


    public function deleteUser(): ServiceResponse
    {
        return $this->execute(function () {
            return $this->deleteUserAction->handle();
        }, "Failed to delete user", "User deleted successfully");
    }

    public function updateSettings(array $settings): ServiceResponse
    {
        return $this->execute(function () use ($settings) {
            return $this->updateSettingsAction->handle($settings);
        }, "Failed to update settings", "Settings updated successfully");
    }

    public function toggleStatus(User $user): ServiceResponse
    {
        return $this->execute(function () use ($user) {
            return $this->toggleStatusAction->handle($user);
        }, "Failed to change status", "Status updated successfully");
    }
}
