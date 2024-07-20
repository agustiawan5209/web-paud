<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiModelController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('get-user', [ApiModelController::class, 'getUser'])->name('api.user.getUser');
Route::get('get-orangtua', [ApiModelController::class, 'getOrgTua'])->name('api.orangtua.getOrgTua');
Route::get('get-anak', [ApiModelController::class, 'getSiswa'])->name('api.siswa.getSiswa');
Route::get('get-data-siswa', [ApiModelController::class, 'geDatatSiswa'])->name('api.siswa.getDataSiswa');

