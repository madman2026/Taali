<?php

use Illuminate\Support\Facades\Route;
use Modules\Media\Http\Controllers\DownloadController;
use Modules\Media\Http\Controllers\MediaController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('media', MediaController::class)->names('media');
});

Route::get('/media/view/{id}' , DownloadController::class)->middleware('throttle:media-view')->name('download');
