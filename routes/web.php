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
use App\Livewire\UniqueCodeInput;

// Route::view('/', 'welcome');

Route::redirect('/', '/id'); // Otomatis arahkan ke /id saat buka domain utama

// route group untuk admin dengan prefix /admin dan middleware auth serta admin
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {
    // tambahkan route untuk halaman admin disini
    Route::view('dashboard', 'dashboard')
        ->name('dashboard.admin');

    Route::view('manage-trip', 'manage-trip')
        ->name('trip.index');

    Route::view('manage-trip/create', 'edit-trip')
        ->name('trip.create');

    Route::view('manage-trip/edit/{tripId}', 'edit-trip')
        ->name('trip.edit');

    Route::view('manage-video', 'manage-video')
        ->name('video.index');

    Route::view('manage-video/create', 'form-video')
        ->name('video.create');

    Route::view('manage-video/edit/{videoId}', 'form-video')
        ->name('video.edit');

    Route::view('manage-motif', 'manage-motif')
        ->name('motif.index');

    Route::view('manage-motif/create', 'form-motif')
        ->name('motif.create');

    Route::view('manage-motif/{motifId}/edit', 'form-motif')
        ->name('motif.edit');

    Route::view('manage-product', 'manage-product')
        ->name('product.index');

    Route::view('manage-product/create', 'form-product')
        ->name('product.create');

    Route::view('manage-product/{productId}/edit', 'form-product')
        ->name('product.edit');

    Route::view('manage-product/{productId}/unique-code', 'manage-unique-code')
        ->name('product.unique-code');

    Route::view('manage-creative-kits', 'manage-creative-kit')
        ->name('creative-kit.index');

    Route::view('manage-creative-kits/create', 'form-creative-kit')
        ->name('creative-kit.create');

    Route::view('manage-creative-kits/{creativeKitId}/edit', 'form-creative-kit')
        ->name('creative-kit.edit');

    Route::view('manage-movement', 'manage-movement-school')
        ->name('movement-school.index');

    Route::view('manage-movement/create', 'form-movement-school')
        ->name('movement-school.create');

    Route::view('manage-movement/{schoolId}/edit', 'form-movement-school')
        ->name('movement-school.edit');

    Route::view('manage-artisan', 'manage-artisan')
        ->name('artisan.index');

    Route::view('manage-artisan/create', 'form-artisan')
        ->name('artisan.create');

    Route::view('manage-artisan/{artisanId}/edit', 'form-artisan')
        ->name('artisan.edit');

    Route::view('manage-schedule', 'manage-internal-schedule')
        ->name('internal-schedule.index');

    Route::view('manage-schedule/create', 'form-internal-schedule')
        ->name('internal-schedule.create');

    Route::view('manage-schedule/{scheduleId}/edit', 'form-internal-schedule')
        ->name('internal-schedule.edit');
});

// route group untuk user dengan prefix /user dan middleware auth serta member
Route::group(['prefix' => 'user', 'middleware' => ['auth', 'member', 'roleuser']], function () {
    // tambahkan route untuk halaman user disini
    Route::view('dashboard', 'dashboard')
        ->name('dashboard.user');
});

Route::view('profile', 'profile')
    ->middleware(['auth', 'admin | member'])
    ->name('profile');

// route untuk input unique code
// Route::get('/input-unique-code', )
//     ->middleware(['auth', 'unmember'])
//     ->name('input-unique-code');

require __DIR__ . '/auth.php';

Route::group(['prefix' => '{locale}', 'middleware' => SetLocale::class], function () {
    Route::get('/', Home::class)->name('home');
    Route::get('/heritage', TheHeritage::class)->name('heritage');

    Route::get('/gallery', TheGallery::class)->name('gallery');
    Route::get('/gallery/cultural-trip/{slug}', CulturalTripDetail::class)->name('trip.show');

    Route::get('/movement', TheMovement::class)->name('movement');
    Route::get('/movement/goes-to-school/{movementSchool:slug}', MovementDetail::class)->name('movement.show');
    Route::get('/movement/artisan/{artisan:slug}', ArtisanDetail::class)->name('artisan.show');

    Route::get('/input-unique-code', UniqueCodeInput::class)->middleware(['auth', 'unmember'])->name('input-unique-code');
});