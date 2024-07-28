<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tableName = 'siswas'; // Ganti dengan nama tabel yang Anda inginkan
        $columns = DB::getSchemaBuilder()->getColumnListing($tableName);

        return Inertia::render('OrangTua/Siswa/Index', [
            'search' =>  Request::input('search'),
            'table_colums' => array_values(array_diff($columns, ['remember_token', 'password', 'org_tua_id', 'email_verified_at', 'created_at', 'updated_at', 'user_id'])),
            'data' => Siswa::filter(Request::only('search', 'order'))
                ->with(['orangTua'])
                ->paginate(10),
            'can' => [
                'add' => Auth::user()->can('add orangtua'),
            ]
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Siswa $siswa)
    {
        return Inertia::render('OrangTua/Siswa/Show', [
            'siswa' => Siswa::with(['orangtua', 'kelas', 'dataabsensi', 'dataperkembangansiswa', 'datanilaisiswa','dataperkembangansiswa.perkembangansiswa',])->find(Request::input('slug')),
        ]);
    }
}
