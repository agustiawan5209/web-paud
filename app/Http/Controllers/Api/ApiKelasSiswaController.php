<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\OrangTua;
use App\Http\Controllers\Controller;
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
        $user = Kelas::find($id);

        return response()->json($user, 200);
    }
}
