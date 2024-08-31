<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Siswa;
use App\Models\OrangTua;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\Http\Requests\StoreSiswaRequest;
use App\Http\Requests\UpdateSiswaRequest;
use App\Models\Kelas;
use App\Models\KelasSiswa;
use Illuminate\Support\Facades\Validator;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function page()
    {
        $tableName = 'kelas'; // Ganti dengan nama tabel yang Anda inginkan
        $columns = DB::getSchemaBuilder()->getColumnListing($tableName);


        return Inertia::render('Admin/Siswa/Page', [
            'search' =>  Request::input('search'),
            'table_colums' => array_values(array_diff($columns, ['remember_token', 'password', 'org_tua_id', 'email_verified_at', 'created_at', 'updated_at', 'user_id'])),
            'data' => Kelas::filter(Request::only('search', 'order'))
                ->with(['kelassiswa'])
                ->paginate(10),
            'can' => [
                'add' => Auth::user()->can('add kelas'),
                'edit' => Auth::user()->can('edit kelas'),
                'delete' => Auth::user()->can('delete kelas'),
                'show' => Auth::user()->can('show kelas'),
            ]
        ]);
    }
    public function index()
    {

        $valid = Validator::make(Request::all(), [
            'slug' => 'required|exists:kelas,id',
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $tableName = 'siswas'; // Ganti dengan nama tabel yang Anda inginkan
        $columns = DB::getSchemaBuilder()->getColumnListing($tableName);
        $kelas_siswa = KelasSiswa::where('kelas_id', Request::input('slug'))->get();
        $siswa = [];
        foreach ($kelas_siswa as $key => $value) {
            $siswa[] = $value->siswa_id;
        }
        // dd($siswa);

        return Inertia::render('Admin/Siswa/Index', [
            'search' =>  Request::input('search'),
            'table_colums' => array_values(array_diff($columns, ['remember_token', 'password', 'org_tua_id', 'email_verified_at', 'created_at', 'updated_at', 'user_id'])),
            'data' => Siswa::filter(Request::only('search', 'order'))
                ->whereIn('id', $siswa)
                ->with(['orangTua'])
                ->paginate(10),
            'can' => [
                'add' => Auth::user()->can('add siswa'),
                'edit' => Auth::user()->can('edit siswa'),
                'delete' => Auth::user()->can('delete siswa'),
                'show' => Auth::user()->can('show siswa'),
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render("Admin/Siswa/Form", [
            'siswa' => Siswa::where('org_tua_id', '=', Request::input('orang_tua'))->get(),
            'orangTua' => Auth::user()->orangtua,
            'can' => [
                'add' => Auth::user()->can('add orangtua'),
            ],
            'kelas' => Kelas::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeForm(StoreSiswaRequest $request)
    {
        Siswa::create($request->all());
        return redirect()->route('Siswa.index')->with('message', 'Data Siswa Berhasil Di tambah!!');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSiswaRequest $request)
    {
        $siswa = Siswa::create($request->all());

        $kelas = Kelas::find($request->kelas);
        KelasSiswa::create([
            'kelas_id' => $kelas->id,
            'siswa_id' => $siswa->id,
            'kelas' => $kelas,
            'siswa' => $siswa,
        ]);

        return redirect()->route('Siswa.index')->with('message', 'Data Siswa Berhasil Di tambah!!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Siswa $siswa)
    {
        Request::validate([
            'slug' => 'required|exists:siswas,id',
        ]);
        return Inertia::render("Admin/Siswa/Show", [
            'siswa' => Siswa::with(['orangTua'])->find(Request::input('slug')),
            'orangTua' => OrangTua::all(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Siswa $siswa)
    {
        Request::validate([
            'slug' => 'required|exists:siswas,id',
        ]);
        return Inertia::render("Admin/Siswa/Edit", [
            'siswa' => Siswa::find(Request::input('slug')),
            'orangTua' => OrangTua::all(),
            'can' => [
                'add' => Auth::user()->can('add orangtua'),
            ],
            'kelas'=> Kelas::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSiswaRequest $request, Siswa $siswa)
    {
        $siswa = Siswa::find(Request::input('slug'))->update($request->all());

        $kelas = Kelas::find($request->kelas);
        KelasSiswa::where('siswa_id', $siswa->id)->update([
            'kelas_id' => $kelas->id,
            'siswa_id' => $siswa->id,
            'kelas' => $kelas,
            'siswa' => $siswa,
        ]);
        return redirect()->route('Siswa.index')->with('message', 'Data Siswa Berhasil Di Edit!!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Siswa $siswa)
    {
        Siswa::find(Request::input('slug'))->delete();
        return redirect()->route('Siswa.index')->with('message', 'Data Siswa Berhasil Di Hapus!!');
    }
}
