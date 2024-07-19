<?php

use App\Http\Controllers\KelasController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
});
