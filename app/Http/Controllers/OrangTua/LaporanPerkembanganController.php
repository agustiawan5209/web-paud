<?php

namespace App\Http\Controllers\OrangTua;

use Inertia\Inertia;
use App\Models\Siswa;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\DataPerkembanganSiswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class LaporanPerkembanganController extends Controller
{
    public function index()
    {
        $tableName = 'siswas'; // Ganti dengan nama tabel yang Anda inginkan
        $columns = DB::getSchemaBuilder()->getColumnListing($tableName);

        return Inertia::render('OrangTua/Perkembangan/Index', [
            'search' =>  Request::input('search'),
            'table_colums' => array_values(array_diff($columns, ['remember_token','org_tua_id', 'kelas_id', 'guru_id', 'password', 'email_verified_at', 'created_at', 'updated_at', 'user_id'])),
            'data' => Siswa::filter(Request::only('search', 'order'))
                ->with(['dataperkembangansiswa', 'datanilaisiswa', 'dataabsensi', 'kelas'])
                ->paginate(10),
            'can' => [
                // 'form' => Auth::user()->can('form nilai'),
                'add' => Auth::user()->can('add nilai'),
                'edit' => Auth::user()->can('edit nilai'),
                'show' => Auth::user()->can('show nilai'),
                'delete' => Auth::user()->can('delete nilai'),
                'reset' => Auth::user()->can('reset nilai'),
            ],
        ]);
    }

    public function show(Siswa $siswa)
    {
        Request::validate([
            'slug'=> 'required|exists:siswas,id',
        ]);
        return Inertia::render("OrangTua/Perkembangan/Show", [
            'siswa' => Siswa::with(['dataperkembangansiswa', 'datanilaisiswa', 'dataabsensi', 'kelas', 'dataperkembangansiswa.perkembangansiswa', 'datanilaisiswa.nilaisiswa', 'dataabsensi.absensi',])->find(Request::input('slug')),
            // 'orangTua'=> OrangTua::all(),
        ]);
    }

    public function update(){
        Request::validate([
            'siswa_id'=> 'required|exists:siswas,id',
            'slug'=> 'required|exists:data_perkembangan_siswas,id',
        ]);
        $request = Request::all();

        DataPerkembanganSiswa::find(Request::input('slug'))->update(['respon'=> $request['respon']]);

        return redirect()->route('Org.Perkembangan.show', ['slug'=> Request::input('siswa_id')])->with('message', 'Berhasil Disimpan!!');
    }
}
