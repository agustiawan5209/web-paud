<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\KelasSiswa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\Http\Requests\StoreKelasSiswaRequest;
use App\Http\Requests\UpdateKelasSiswaRequest;

class KelasSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tableName = 'kelas_siswas'; // Ganti dengan nama tabel yang Anda inginkan
        $columns = DB::getSchemaBuilder()->getColumnListing($tableName);

        return Inertia::render('Admin/Siswa/Index', [
            'search' =>  Request::input('search'),
            'table_colums' => array_values(array_diff($columns, ['remember_token', 'password', 'org_tua_id', 'email_verified_at', 'created_at', 'updated_at', 'user_id'])),
            'data' => KelasSiswa::filter(Request::only('search', 'order'))
            ->paginate(10),
            'can'=>[
                'add'=> Auth::user()->can('add Siswa'),
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/KelasSiswa/Form', [
            'kelas'=> Kelas::all(),
            'siswa'=> Siswa::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKelasSiswaRequest $request)
    {
        $kelas = Kelas::find($request->kelas_id);
        $siswa = Siswa::find($request->siswa);
        KelasSiswa::create([
            'kelas_id' => $request->kelas_id,
            'siswa_id' => $request->siswa_id,
            'kelas' => $kelas,
            'siswa' => $siswa,
        ]);
        return redirect()->route('Kelas-Siswa.index')->with('message', 'Data Kelas Siswa Berhasil Di Tambah!!');
    }

    /**
     * Display the specified resource.
     */
    public function show(KelasSiswa $kelasSiswa)
    {
        return Inertia::render('Admin/KelasSiswa/Show',[
            'kelas_siswa'=> KelasSiswa::find(Request::input('slug')),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KelasSiswa $kelasSiswa)
    {
        return Inertia::render('Admin/KelasSiswa/Edit',[
            'kelas_siswa'=> KelasSiswa::find(Request::input('slug')),
            'kelas'=> Kelas::all(),
            'siswa'=> Siswa::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKelasSiswaRequest $request, KelasSiswa $kelasSiswa)
    {
        $kelas = Kelas::find($request->kelas_id);
        $siswa = Siswa::find($request->siswa);
        KelasSiswa::find(Request::input('slug'))->update([
            'kelas_id' => $request->kelas_id,
            'siswa_id' => $request->siswa_id,
            'kelas' => $kelas,
            'siswa' => $siswa,
        ]);
        return redirect()->route('Kelas-Siswa.index')->with('message', 'Data Kelas Siswa Berhasil Di Ubah!!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KelasSiswa $kelasSiswa)
    {
        KelasSiswa::find(Request::input('slug'))->delete();
        return redirect()->route('Kelas-Siswa.index')->with('message', 'Data Kelas Siswa Berhasil Di Hapus!!');
    }
}
