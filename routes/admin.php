<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\OrangTuaController;
use App\Http\Controllers\Admin\JadwalKegiatanController;
use App\Http\Controllers\Admin\KelasSiswaController;
use App\Http\Controllers\Admin\TahunAjaranController;

Route::middleware(['auth', 'verified', 'role:Admin'])->group(function () {
    // Router Tahun Ajar
    Route::group(['prefix' => 'tahun-ajar', 'as' => "TahunAjar."], function () {
        Route::controller(TahunAjaranController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/tambah-data/tahun-ajar', 'create')->name('create');
            Route::get('/edit-data/tahun-ajar', 'edit')->name('edit');
            Route::get('/detail-data/tahun-ajar', 'show')->name('show');
            Route::post('/store-data/tahun-ajar', 'store')->name('store');
            Route::put('/update-data/tahun-ajar', 'update')->name('update');
            Route::delete('/hapus-data/tahun-ajar', 'destroy')->name('destroy');
        });
    });
    // Router Kelas
    Route::group(['prefix' => 'kelas', 'as' => "Kelas."], function () {
        Route::controller(KelasController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/tambah-data/kelas', 'create')->name('create');
            Route::get('/edit-data/kelas', 'edit')->name('edit');
            Route::get('/detail-data/kelas', 'show')->name('show');
            Route::post('/store-data/kelas', 'store')->name('store');
            Route::put('/update-data/kelas', 'update')->name('update');
            Route::delete('/hapus-data/kelas', 'destroy')->name('destroy');
        });
    });

    //
    Route::group(['prefix' => 'guru', 'as' => "Guru."], function () {
        Route::controller(GuruController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/tambah-data-guru', 'create')->name('create');
            Route::get('/edit-data-guru', 'edit')->middleware(['auth', 'password.confirm'])->name('edit');
            Route::post('/store-data-guru', 'store')->name('store');
            Route::put('/update-data-guru', 'update')->name('update');
            Route::delete('/hapus-data-guru', 'destroy')->name('destroy');

            // reset password

            Route::get('/reset-password-guru', 'resetpassword')->middleware(['auth', 'password.confirm'])->name('reset.password');
            Route::post('/reset-password-guru', 'resetpasswordUpdate')->name('reset.password');
        });
    });

    // Router Orang Tua
    Route::group(['prefix' => 'orang-tua', 'as' => "OrangTua.",], function () {
        Route::controller(OrangTuaController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/tambah-data-orangtua', 'create')->name('create');
            Route::get('/ubah-data-orangtua', 'edit')->name('edit');
            Route::get('/detail-data-orangtua', 'show')->name('show');
            Route::post('/store-data-orangtua', 'store')->name('store');
            Route::put('/update-data-orangtua', 'update')->name('update');
            Route::delete('/hapus-data-orangtua', 'destroy')->name('destroy');

            // reset password

            Route::get('/reset-password-orang-tua', 'resetpassword')->middleware(['auth', 'password.confirm'])->name('reset.password');
            Route::post('/reset-password-orang-tua', 'resetpasswordUpdate')->name('reset.password');
        });
    });

    // Siswa
    Route::group(['prefix' => 'siswa', 'as' => "Siswa."], function () {
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
    Route::group(['prefix' => 'kelas-siswa', 'as' => "KelasSiswa."], function () {
        Route::controller(KelasSiswaController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/tambah-data-kelas-siswa', 'create')->name('create');
            Route::get('/detail-data-kelas-siswa', 'show')->name('show');
            Route::get('/edit-data-kelas-siswa', 'edit')->name('edit');
            Route::post('/store-data-kelas-siswa', 'store')->name('store');
            Route::put('/update-data-kelas-siswa', 'update')->name('update');
            Route::delete('/hapus-data-kelas-siswa', 'destroy')->name('destroy');
        });
    });

     // Router Jadwal
     Route::group(['prefix' => 'jadwal-kegiatan', 'as' => "Jadwal."], function () {
        Route::controller(JadwalKegiatanController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/tambah-data/jadwal-kegiatan', 'create')->name('create');
            Route::get('/edit-data/jadwal-kegiatan', 'edit')->name('edit');
            Route::get('/detail-data/jadwal-kegiatan', 'show')->name('show');
            Route::post('/store-data/jadwal-kegiatan', 'store')->name('store');
            Route::put('/update-data/jadwal-kegiatan', 'update')->name('update');
            Route::delete('/hapus-data/jadwal-kegiatan', 'destroy')->name('destroy');
        });
    });
});
