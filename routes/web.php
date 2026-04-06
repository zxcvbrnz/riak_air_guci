<?php

use App\Livewire\Pages\Home;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SetLocale;
use App\Livewire\Pages\MovementDetail;
use App\Livewire\Pages\ArtisanDetail;
use App\Livewire\Pages\CulturalTripDetail;
use App\Livewire\Pages\TheGallery;
use App\Livewire\Pages\TheHeritage;
use App\Livewire\Pages\TheMovement;

// Route::view('/', 'welcome');

Route::redirect('/', '/id'); // Otomatis arahkan ke /id saat buka domain utama

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('manage-trip', 'manage-trip')
    ->middleware(['auth', 'verified'])
    ->name('trip.index');

Route::view('manage-trip/create', 'edit-trip')
    ->middleware(['auth', 'verified'])
    ->name('trip.create');

Route::view('manage-trip/edit/{tripId}', 'edit-trip')
    ->middleware(['auth', 'verified'])
    ->name('trip.edit');

Route::view('manage-video', 'manage-video')
    ->middleware(['auth', 'verified'])
    ->name('video.index');

Route::view('manage-video/create', 'form-video')
    ->middleware(['auth', 'verified'])
    ->name('video.create');

Route::view('manage-video/edit/{videoId}', 'form-video')
    ->middleware(['auth', 'verified'])
    ->name('video.edit');

Route::view('manage-motif', 'manage-motif')
    ->middleware(['auth', 'verified'])
    ->name('motif.index');

Route::view('manage-motif/create', 'form-motif')
    ->middleware(['auth', 'verified'])
    ->name('motif.create');

Route::view('manage-motif/edit/{motifId}', 'form-motif')
    ->middleware(['auth', 'verified'])
    ->name('motif.edit');

Route::view('manage-product', 'manage-product')
    ->middleware(['auth', 'verified'])
    ->name('product.index');

Route::view('manage-product/create', 'form-product')
    ->middleware(['auth', 'verified'])
    ->name('product.create');

Route::view('manage-product/edit/{productId}', 'form-product')
    ->middleware(['auth', 'verified'])
    ->name('product.edit');

Route::view('manage-creative-kits', 'manage-creative-kit')
    ->middleware(['auth', 'verified'])
    ->name('creative-kit.index');

Route::view('manage-creative-kits/create', 'form-creative-kit')
    ->middleware(['auth', 'verified'])
    ->name('creative-kit.create');

Route::view('manage-creative-kits/edit/{creativeKitId}', 'form-creative-kit')
    ->middleware(['auth', 'verified'])
    ->name('creative-kit.edit');

Route::view('manage-movement', 'manage-movement-school')
    ->middleware(['auth', 'verified'])
    ->name('movement-school.index');

Route::view('manage-movement/create', 'form-movement-school')
    ->middleware(['auth', 'verified'])
    ->name('movement-school.create');

Route::view('manage-movement/edit/{schoolId}}', 'form-movement-school')
    ->middleware(['auth', 'verified'])
    ->name('movement-school.edit');

Route::view('manage-artisan', 'manage-artisan')
    ->middleware(['auth', 'verified'])
    ->name('artisan.index');

Route::view('manage-artisan/create', 'form-artisan')
    ->middleware(['auth', 'verified'])
    ->name('artisan.create');

Route::view('manage-artisan/edit/{artisanId}', 'form-artisan')
    ->middleware(['auth', 'verified'])
    ->name('artisan.edit');

Route::view('manage-schedule', 'manage-internal-schedule')
    ->middleware(['auth', 'verified'])
    ->name('internal-schedule.index');

Route::view('manage-schedule/create', 'form-internal-schedule')
    ->middleware(['auth', 'verified'])
    ->name('internal-schedule.create');

Route::view('manage-schedule/edit/{scheduleId}', 'form-internal-schedule')
    ->middleware(['auth', 'verified'])
    ->name('internal-schedule.edit');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';

Route::group(['prefix' => '{locale}', 'middleware' => SetLocale::class], function () {
    Route::get('/', Home::class)->name('home');
    Route::get('/heritage', TheHeritage::class)->name('heritage');

    Route::get('/gallery', TheGallery::class)->name('gallery');
    Route::get('/gallery/cultural-trip/{slug}', CulturalTripDetail::class)->name('trip.show');

    Route::get('/movement', TheMovement::class)->name('movement');
    Route::get('/movement/goes-to-school/{movementSchool:slug}', MovementDetail::class)->name('movement.show');
    Route::get('/movement/artisan/{artisan:slug}', ArtisanDetail::class)->name('artisan.show');
});
