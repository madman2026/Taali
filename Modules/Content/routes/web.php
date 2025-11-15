<?php

use Illuminate\Support\Facades\Route;
use Modules\Content\Http\Controllers\ContentController;

Route::as('content.')->prefix('content')->group(function () {
    Route::get('/index', \Modules\Content\Livewire\ContentIndex::class)->name('index');
    Route::get('/visited-content', \Modules\Content\Livewire\VisitedContent::class)->name('visited');

});
