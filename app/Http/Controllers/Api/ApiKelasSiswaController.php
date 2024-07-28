<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\OrangTua;
use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\NilaiSiswa;
use Illuminate\Support\Facades\Request;

class ApiKelasSiswaController extends Controller
{

    /**
     * getSiswa
     *
     * @return void
     */
    public function getSiswa()
    {
        $search = Request::only('search');

        $user = Siswa::filter($search)->get();

        return response()->json($user, 200);
    }

    public function getKelas()
    {
        $search = Request::only('search');
        $user = Kelas::filter($search)->get();
        return response()->json($user, 200);
    }

    /**
     * getSiswaID
     *
     * @param  mixed $id
     * @return void
     */
    public function getSiswaID($id)
    {
        $user = Siswa::find($id);

        return response()->json($user, 200);
    }

    /**
     * getKelasID
     *
     * @param  mixed $id
     * @return void
     */
    public function getKelasID($id)
    {
        $user = Kelas::with(['kelassiswa'])->find($id);

        return response()->json($user, 200);
    }

    public function getAbsensi($tanggal, $kelas_id)
    {
        $absensi = Absensi::where('kelas_id', $kelas_id)->whereDate('tanggal', $tanggal)->get();

        if ($absensi->count() > 0) {
            return response()->json([
                'status' => true,
                'data' => $absensi,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'data' => $absensi,

            ], 200);
        }
    }

    public function getNilaiSiswa($tanggal, $kelas_id)
    {
        $nilai = NilaiSiswa::where('kelas_id', $kelas_id)->whereDate('tanggal', $tanggal)->get();

        if ($nilai->count() > 0) {
            return response()->json([
                'status' => true,
                'data' => $nilai,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'data' => $nilai,

            ], 200);
        }
    }
}
