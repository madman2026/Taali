<?php

use Illuminate\Support\Facades\Route;
use Modules\Media\Http\Controllers\DownloadController;

Route::get('/media/view/{id}', DownloadController::class)->middleware('throttle:media-view')->name('download');
