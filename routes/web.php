<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\LaporanJadwalController;
use App\Http\Controllers\MessageController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/informasi-puskesmas', [HomeController::class, 'informasi'])->name('Home.informasi');

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/photo-profile', [ProfileController::class, 'updatePhoto'])->name('profile.updatePhoto');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/guru.php';
require __DIR__ . '/orangtua.php';


// Laporan

Route::group(['prefix' => 'laporan', 'as' => "Laporan."], function () {
    Route::controller(LaporanJadwalController::class)->group(function () {
        Route::get('/jadwal', 'cetak')->name('jadwal.cetak');
        Route::get('/jadwal-harian', 'cetakharian')->name('jadwal.cetak-harian');
    });
});

 // Route Setting
 Route::group(['prefix' => 'setting-paud', 'as' => "Setting."], function () {
    Route::controller(InformasiController::class)->group(function () {
        Route::get('/', 'create')->name('create');
        Route::post('/store-data-paud', 'store')->name('store');
    });
});


Route::get('/chat/{recipientId}', [MessageController::class, 'index']);
Route::post('/chat', [MessageController::class, 'store']);
Route::get('/chat/chatroom/{recepient_id}', [MessageController::class, 'getChatRoom']);
Route::put('/chat/{recipientId}', [MessageController::class, 'update']);

Route::get('/chat/search/room', [MessageController::class, 'findChat']);
Route::get('/chat/not/read', [MessageController::class, 'chatNotRead']);

