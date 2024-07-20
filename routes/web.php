<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\OrangTuaController;
use App\Http\Controllers\TahunAjaranController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

// Admin

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

    Route::group(['prefix' => 'siswa', 'as' => "Siswa."], function () {
        Route::controller(SiswaController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/tambah-data-siswa', 'create')->name('create');
            Route::get('/detail-data-siswa', 'show')->name('show');
            Route::get('/edit-data-siswa', 'edit')->middleware(['auth', 'password.confirm'])->name('edit');
            Route::post('/store-data-siswa', 'store')->name('store');
            Route::put('/update-data-siswa', 'update')->name('update');
            Route::delete('/hapus-data-siswa', 'destroy')->name('destroy');

            // reset password

            Route::get('/reset-password-siswa', 'resetpassword')->middleware(['auth', 'password.confirm'])->name('reset.password');
            Route::post('/reset-password-siswa', 'resetpasswordUpdate')->name('reset.password');
        });
    });
});
