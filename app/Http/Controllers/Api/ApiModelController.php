<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Siswa;
use App\Models\OrangTua;
use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Informasi;
use Illuminate\Support\Facades\Request;

class ApiModelController extends Controller
{

    /**
     * getUser
     *
     * @return void
     */
    public function getUser()
    {
        $search = Request::input('search');

        $user = User::filter($search)->role('Kader')->get();

        return json_encode($user);
    }


    /**
     * getOrgTua
     *
     * @return void
     */
    public function getOrgTua()
    {
        $search = Request::only('search');

        $user = OrangTua::filter($search)->get();

        return json_encode($user);
    }

    /**
     * getSiswa
     *
     * @return void
     */
    public function getSiswa()
    {
        $search = Request::only('search');

        $user = Siswa::with(['orangTua'])->filter($search)->get();

        return json_encode($user);
    }

    /**
     * geDatatSiswa
     *
     * @return void
     */
    public function geDatatSiswa()
    {
        $search = Request::only('search');

        $user = Siswa::with(['orangTua'])->filter($search)->get();

        return json_encode($user);
    }
    /**
     * geDatatGuru
     *
     * @return void
     */
    public function getDataGuru()
    {
        $search = Request::only('search');

        $user = Guru::filter($search)->get();

        return response()->json($user,200);
    }
    public function getIDGuru($id)
    {
        $user = Guru::find($id);

        return response()->json($user,200);
    }

    /**
     * getDoughnatChart
     *
     * @return void
     */
    public function getDoughnatChart()
    {

        $siswa = Siswa::all()->count();
        $org = User::role('Orang Tua')->get()->count();
        $kader = User::role('Guru')->get()->count();
        $data = [$siswa, $org, $kader];
        $label = ['Siswa', 'Orang Tua', 'Guru'];

        return json_encode([
            'data_chart' => $data,
            'label' => $label,
        ]);
    }

    public function SettingInformasi()
    {
        $informasi = Informasi::find(1);

        return json_encode($informasi);
    }

}
