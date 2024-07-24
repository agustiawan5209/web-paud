<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Kelas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\Http\Requests\StoreKelasRequest;
use App\Http\Requests\UpdateKelasRequest;
use App\Models\Guru;
use App\Models\TahunAjaran;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tableName = 'kelas'; // Ganti dengan nama tabel yang Anda inginkan
        $columns = DB::getSchemaBuilder()->getColumnListing($tableName);
        // dd($columns);
        // dd(Kelas::with(['kader'])->find(1));

        return Inertia::render('Admin/Kelas/Index', [
            'search' =>  Request::input('search'),
            'table_colums' => array_values(array_diff($columns, ['remember_token', 'guru_id', 'password', 'email_verified_at', 'created_at', 'updated_at', 'user_id'])),
            'data' => Kelas::filter(Request::only('search', 'order'))->paginate(10),
            'can' => [
                'add' => Auth::user()->can('add kelas'),
                'edit' => Auth::user()->can('edit kelas'),
                'show' => false,
                'delete' => Auth::user()->can('delete kelas'),
                'reset' => Auth::user()->can('reset kelas'),
            ],
            'relasi'=> [
                'tahun_ajarans'=> TahunAjaran::all(),
                'gurus'=> Guru::all(),
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Kelas/Form', []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKelasRequest $request)
    {
        $data = $request->all();
        $guru = Guru::find($request->guru);
        $data['guru'] = $guru->nama;
        $data['guru_id'] = $guru->id;
        $kelas = Kelas::create($data);

        return redirect()->route('Kelas.index')->with('message', 'Data Berhasil Di Tambah!!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kelas $kelas)
    {
        return Inertia::render('Admin/Kelas/Form', [
            'kelas'=> $kelas->find(Request::input('slug')),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kelas $kelas)
    {
        return response()->json($kelas->find(Request::input('slug')), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKelasRequest $request, Kelas $kelas)
    {
        $data = $request->all();
        $guru = Guru::find($request->guru);
        $data['guru'] = $guru->nama;
        $data['guru_id'] = $guru->id;
        $kelas = Kelas::find($request->id)->update($data);

        return redirect()->route('Kelas.index')->with('message', 'Data Berhasil Di ubah!!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kelas $kelas)
    {
        $kelas = Kelas::find(Request::input('slug'))->delete();

        return redirect()->route('Kelas.index')->with('message', 'Data Berhasil Di Hapus!!');
    }
}
