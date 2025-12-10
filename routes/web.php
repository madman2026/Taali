<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\Home::class)->name('home');

Route::get('about', \App\Livewire\About::class)->name('about');
Route::get('contact', \App\Livewire\Contact::class)->name('contact');
Route::get('search', \App\Livewire\Search::class)->name('search');
