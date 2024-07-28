<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrangTua\SiswaController;
Route::middleware(['auth', 'verified', 'role:Orang Tua'])->group(function () {

    // Siswa
    Route::group(['prefix' => 'data-siswa', 'as' => "Org.Siswa."], function () {
        Route::controller(SiswaController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/tambah-data-siswa', 'create')->name('create');
            Route::get('/detail-data-siswa', 'show')->name('show');
            Route::get('/edit-data-siswa', 'edit')->middleware(['auth', 'password.confirm'])->name('edit');
            Route::post('/store-data-siswa', 'store')->name('store');
            Route::put('/update-data-siswa', 'update')->name('update');
            Route::delete('/hapus-data-siswa', 'destroy')->name('destroy');
        });
    });

});
