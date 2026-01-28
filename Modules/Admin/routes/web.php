<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'role:super-admin'])->as('admin.')->prefix('admin')->group(function () {
    Route::get('dashboard', \Modules\Admin\Livewire\AdminDashboard::class)->name('dashboard');
    Route::get('file/dashboard', \Modules\Admin\Livewire\FileDashboard::class)->name('file.dashboard');
    Route::get('test', function () {
        \Modules\Admin\Jobs\CampainJob::dispatch()->delay(now()->addSeconds(3.1));
    })->name('test');
});
