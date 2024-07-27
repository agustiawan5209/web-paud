<?php

use App\Http\Controllers\Guru\AbsensiController;
use App\Http\Controllers\Guru\DataAbsensiController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'verified', 'role:Guru'])->group(function () {

    // Router Absen
    Route::group(['prefix' => 'absen', 'as' => "Absen."], function () {
        Route::controller(AbsensiController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/tambah-data/absen', 'create')->name('create');
            Route::get('/edit-data/absen', 'edit')->name('edit');
            Route::get('/detail-data/absen', 'show')->name('show');
            Route::post('/store-data/absen', 'store')->name('store');
            Route::put('/update-data/absen', 'update')->name('update');
            Route::delete('/hapus-data/absen', 'destroy')->name('destroy');
        });
    });
});
