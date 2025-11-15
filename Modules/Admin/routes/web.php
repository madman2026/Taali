<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\AdminController;

Route::middleware(['auth', 'verified' , 'role:admin'])->as('admin.')->prefix('admin')->group(function () {
    Route::get('dashboard', \Modules\Admin\Livewire\AdminDashboard::class)->name('dashboard');
    Route::get('file/dashboard', \Modules\Admin\Livewire\FileDashboard::class)->name('file.dashboard');
});
