<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::prefix('comment')->as('comment.')->group(function () {
        Route::get('', \Modules\Interaction\Livewire\CommentIndex::class)->name('index');
    });
});
