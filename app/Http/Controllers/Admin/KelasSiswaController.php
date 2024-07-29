<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\KelasSiswa;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
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
        // $columns = DB::getSchemaBuilder()->getColumnListing($tableName);
        $columns[] = 'id';
        $columns[] = 'nama_kelas';
        $columns[] = 'nama_siswa';


        return Inertia::render('Admin/KelasSiswa/Index', [
            'search' =>  Request::input('search'),
            'table_colums' => array_values(array_diff($columns, ['remember_token', 'kelas_id', 'siswa_id', 'password', 'org_tua_id', 'email_verified_at', 'created_at', 'updated_at', 'user_id'])),
            'data' => KelasSiswa::filter(Request::only('search', 'order'))
                ->paginate(10),
            'can' => [
                'add' => Auth::user()->can('add siswa'),
                'add' => Auth::user()->can('add kelas'),
                'edit' => false,
                'show' => false,
                'delete' => Auth::user()->can('delete kelas'),
            ],

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/KelasSiswa/Form', [
            'kelas' => Kelas::all(),
            'siswa' => Siswa::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKelasSiswaRequest $request)
    {
        $kelas = Kelas::find($request->kelas_id);
        $siswa = Siswa::find($request->siswa_id);
        $kelas_siswa = KelasSiswa::where('kelas_id', '=', $request->kelas_id)
            ->where('siswa_id', '=', $request->siswa_id)
            ->get();

        if ($kelas_siswa->count() > 0) {
            return redirect()->back()->with('message', 'Data Kelas Siswa Berhasil Di Tambah!!');
        }
        KelasSiswa::create([
            'kelas_id' => $request->kelas_id,
            'siswa_id' => $request->siswa_id,
            'kelas' => $kelas,
            'siswa' => $siswa,
        ]);
        return redirect()->route('KelasSiswa.index')->with('message', 'Data Kelas Siswa Berhasil Di Tambah!!');
    }

    /**
     * Display the specified resource.
     */
    public function show(KelasSiswa $kelasSiswa)
    {
        return Inertia::render('Admin/KelasSiswa/Show', [
            'kelas_siswa' => KelasSiswa::find(Request::input('slug')),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KelasSiswa $kelasSiswa)
    {
        return Inertia::render('Admin/KelasSiswa/Edit', [
            'kelas_siswa' => KelasSiswa::find(Request::input('slug')),
            'kelas' => Kelas::all(),
            'siswa' => Siswa::all(),
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
        return redirect()->route('KelasSiswa.index')->with('message', 'Data Kelas Siswa Berhasil Di Ubah!!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KelasSiswa $kelasSiswa)
    {
        KelasSiswa::find(Request::input('slug'))->delete();
        return redirect()->route('KelasSiswa.index')->with('message', 'Data Kelas Siswa Berhasil Di Hapus!!');
    }
}
