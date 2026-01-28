<?php

use Illuminate\Support\Facades\Route;

Route::as('content.')->prefix('content')->group(function () {
    Route::prefix('admin')->middleware(['role:super-admin'])->group(function () {
        Route::get('create', \Modules\Content\Livewire\ContentCreate::class)->name('create');
        Route::get('update\{Content}', \Modules\Content\Livewire\ContentUpdate::class)->name('update');
    });
    Route::get('/index', \Modules\Content\Livewire\ContentIndex::class)->name('index');
    Route::get('/s/{Content}', \Modules\Content\Livewire\ContentShow::class)->middleware('view_content')->name('show');
    Route::get('/s/{Content}/update', \Modules\Content\Livewire\ContentUpdate::class)->name('edit');
    Route::get('/visited-content', \Modules\Content\Livewire\VisitedContent::class)->name('visited');

});
