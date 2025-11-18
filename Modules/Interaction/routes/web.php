<?php

use Illuminate\Support\Facades\Route;
use Modules\Interaction\Http\Controllers\InteractionController;

Route::middleware('auth')->group(function () {
    Route::prefix('comment')->as('comment.')->group(function () {
        Route::get('' , \Modules\Interaction\Livewire\CommentIndex::class)->name('index');
    });
});
