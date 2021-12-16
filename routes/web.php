<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\LinksController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

Route::prefix('profile')->name('profile.')->middleware('auth')->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('index');
});

Route::get('my-places', [PlaceController::class, 'myplaces'])
    ->name('myplaces')
    ->middleware('auth');
Route::post('my-places/delete/all', [PlaceController::class, 'destroyAll'])
    ->name('myplaces.destroyAll')
    ->middleware('auth');
Route::post('my-places/delete/{placed:uuid}', [PlaceController::class, 'destroy'])
    ->name('myplaces.destroy')
    ->middleware('auth');
Route::get('my-places/update/{placed:uuid}', [PlaceController::class, 'update'])
    ->name('myplaces.update')
    ->middleware('auth');

Route::get('about', [LinksController::class, 'about'])
    ->name('about');

Route::get('contact-us', [ContactController::class, 'index'])
    ->name('contact');
Route::post('contact-us', [ContactController::class, 'store']);

Route::get('{placed:uuid}', [PlaceController::class, 'index'])
    ->name('place');

Route::get('/exports/{type}/{size}/{uuid}', ExportController::class)
    ->name('export');

Route::get('/', [LinksController::class, 'index'])->name('home');