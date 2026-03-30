<?php

use App\Livewire\Pages\Home;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SetLocale;
use App\Livewire\Pages\TheGallery;
use App\Livewire\Pages\TheHeritage;
use App\Livewire\Pages\TheMovement;

// Route::view('/', 'welcome');

Route::redirect('/', '/id'); // Otomatis arahkan ke /id saat buka domain utama

Route::group(['prefix' => '{locale}', 'middleware' => SetLocale::class], function () {
    Route::get('/', Home::class)->name('home');
    Route::get('/heritage', TheHeritage::class)->name('heritage');
    Route::get('/gallery', TheGallery::class)->name('gallery');
    Route::get('/movement', TheMovement::class)->name('movement');
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';