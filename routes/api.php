<?php

use App\Http\Controllers\Api\ApiKelasSiswaController;
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
// Guru
Route::get('get-guru', [ApiModelController::class, 'getDataGuru'])->name('api.Guru.data');
Route::get('get-guru/{id}', [ApiModelController::class, 'getIDGuru'])->name('api.Guru.byID');

// Kelas SIswa
Route::get('get-siswa/{id}', [ApiKelasSiswaController::class, 'getSiswaID'])->name('api.siswa.byID');
Route::get('get-kelas/{id}', [ApiKelasSiswaController::class, 'getKelasID'])->name('api.kelas.byID');
Route::get('get-siswa', [ApiKelasSiswaController::class, 'getSiswa'])->name('api.siswa.bySearch');
Route::get('get-kelas', [ApiKelasSiswaController::class, 'getKelas'])->name('api.kelas.bySearch');
Route::get('get-absensi/{tanggal}/{kelas_id}', [ApiKelasSiswaController::class, 'getAbsensi'])->name('api.getAbsensi');
Route::get('get-data-nilai/{tanggal}/{kelas_id}', [ApiKelasSiswaController::class, 'getNilaiSiswa'])->name('api.getNilaiSiswa');
Route::get('get-data-perkembangan/{tanggal}/{kelas_id}', [ApiKelasSiswaController::class, 'getKelasPerkembangan'])->name('api.getKelasPerkembangan');

