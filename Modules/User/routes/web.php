<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\LogoutController;

Route::middleware('guest')->prefix('auth')->group(function () {
    Route::get('login', \Modules\User\Livewire\Auth\Login::class)->name('login');
    Route::get('register', \Modules\User\Livewire\Auth\Register::class)->name('register');
});

// 'verification.notice' should be maked

Route::middleware('auth')->prefix('user')->group(function () {
    Route::post('logout', LogoutController::class)->middleware('auth')->name('logout');

    Route::get('reset-password', \Modules\User\Livewire\User\ResetPassword::class)->name('password.reset');

    Route::get('dashboard', \Modules\User\Livewire\User\Dashboard::class)->name('dashboard');

    Route::get('notifications', \Modules\User\Livewire\User\Notifications::class)->name('notifications');

    Route::get('profile', \Modules\User\Livewire\User\UpdateUser::class)->name('profile');

    Route::get('settings', \Modules\User\Livewire\User\Settings::class)->name('settings');

    Route::put('account-deactivate', \Modules\User\Http\Controllers\DeactivateUserController::class)->name('user.deactivate');

    Route::delete('account-delete', \Modules\User\Http\Controllers\DeleteUserController::class)->name('user.delete');

});
