<?php

use App\Http\Controllers\OrangTua\JadwalKegiatanController;
use App\Http\Controllers\OrangTua\LaporanPerkembanganController;
use App\Http\Controllers\OrangTua\NilaiHarianController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrangTua\SiswaController;

Route::middleware(['auth', 'verified', 'role:Orang Tua'])->group(function () {

    // Siswa
    Route::group(['prefix' => 'data-siswa', 'as' => "Org.Siswa."], function () {
        Route::controller(SiswaController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/detail-data-siswa', 'show')->name('show');
        });
    });
    Route::group(['prefix' => 'data-kegiatan', 'as' => "Org.Kegiatan."], function () {
        Route::controller(JadwalKegiatanController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/detail-data-kegiatan', 'show')->name('show');
        });
    });
    Route::group(['prefix' => 'data-nilai', 'as' => "Org.Nilai."], function () {
        Route::controller(NilaiHarianController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/detail-data-nilai', 'show')->name('show');
        });
    });
    Route::group(['prefix' => 'data-perkembangan', 'as' => "Org.Perkembangan."], function () {
        Route::controller(LaporanPerkembanganController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/detail-data-perkembangan', 'show')->name('show');
            Route::put('update-laporan', 'update')->name('update');
        });
    });

});
