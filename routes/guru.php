<?php

use App\Http\Controllers\Guru\AbsensiController;
use App\Http\Controllers\Guru\JadwalKegiatanController;
use App\Http\Controllers\Guru\NilaiSiswaController;
use App\Http\Controllers\Guru\PerkembanganSiswaController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'verified', 'role:Guru'])->group(function () {

    // Router Jadwal Kegiatan
    Route::group(['prefix' => 'jadwal-guru', 'as' => "Guru.Jadwal."], function () {
        Route::controller(JadwalKegiatanController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/tambah-data/jadwal', 'create')->name('create');
            Route::get('/edit-data/jadwal', 'edit')->name('edit');
            Route::get('/detail-data/jadwal', 'show')->name('show');
            Route::post('/store-data/jadwal', 'store')->name('store');
            Route::put('/update-data/jadwal', 'update')->name('update');
            Route::delete('/hapus-data/jadwal', 'destroy')->name('destroy');
        });
    });
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
    // Router Nilai
    Route::group(['prefix' => 'nilai', 'as' => "NilaiSiswa."], function () {
        Route::controller(NilaiSiswaController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/tambah-data/nilai', 'create')->name('create');
            Route::get('/edit-data/nilai', 'edit')->name('edit');
            Route::get('/detail-data/nilai', 'show')->name('show');
            Route::post('/store-data/nilai', 'store')->name('store');
            Route::put('/update-data/nilai', 'update')->name('update');
            Route::delete('/hapus-data/nilai', 'destroy')->name('destroy');
        });
    });


    // Router Perkembangan
    Route::group(['prefix' => 'perkembangan-siswa', 'as' => "Perkembangan."], function () {
        Route::controller(PerkembanganSiswaController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/tambah-data/perkembangan-siswa', 'create')->name('create');
            Route::get('/edit-data/perkembangan-siswa', 'edit')->name('edit');
            Route::get('/detail-data/perkembangan-siswa', 'show')->name('show');
            Route::post('/store-data/perkembangan-siswa', 'store')->name('store');
            Route::put('/update-data/perkembangan-siswa', 'update')->name('update');
            Route::delete('/hapus-data/perkembangan-siswa', 'destroy')->name('destroy');


            Route::get('/buat-data/nilai', 'form')->name('form');
            Route::post('/store-data/nilai-siswa', 'storeForm')->name('store.form');
        });
    });
});
