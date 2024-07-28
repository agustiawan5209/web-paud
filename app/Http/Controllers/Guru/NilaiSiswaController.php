<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use Inertia\Inertia;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\NilaiSiswa;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\Http\Requests\StoreNilaiSiswaRequest;
use App\Http\Requests\UpdateNilaiSiswaRequest;
use App\Models\DataNilaiSiswa;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class NilaiSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tableName = 'nilai_siswas'; // Ganti dengan nama tabel yang Anda inginkan
        // $columns = DB::getSchemaBuilder()->getColumnListing($tableName);
        $columns[] = 'id';
        $columns[] = 'tanggal';
        $columns[] = 'nama_kelas';
        return Inertia::render('Guru/Nilai/Index', [
            'search' =>  Request::input('search'),
            'table_colums' => array_values(array_diff($columns, ['remember_token', 'kelas_id', 'guru_id', 'password', 'email_verified_at', 'created_at', 'updated_at', 'user_id'])),
            'data' => NilaiSiswa::filter(Request::only('search', 'order'))
                ->with(['kelas', 'datanilaiSiswa'])
                ->where('guru_id', Auth::user()->guru->id)
                ->paginate(10),
            'can' => [
                // 'form' => Auth::user()->can('form nilai'),
                'add' => Auth::user()->can('add nilai'),
                'edit' => Auth::user()->can('edit nilai'),
                'show' => Auth::user()->can('show nilai'),
                'delete' => Auth::user()->can('delete nilai'),
                'reset' => Auth::user()->can('reset nilai'),
            ],
            'relasi' => [
                'tahun_ajarans' => TahunAjaran::all(),
                'gurus' => Guru::all(),
                'kelas' => Kelas::all(),
                'siswa' => Siswa::all(),
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return Inertia::render('Guru/Nilai/Form', [
            'kelas' => Kelas::where('guru_id', Auth::user()->guru->id)->get(),
            'siswa' => Siswa::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNilaiSiswaRequest $request)
    {
        $nilai = $request->all();
        $siswa = $request->siswa;
        $nilaiSiswa =  NilaiSiswa::create([
            'kelas_id' => $request->kelas_id,
            'guru_id' => Auth::user()->guru->id,
            'tanggal' => $request->tanggal,
        ]);
        for ($i = 0; $i < count($siswa); $i++) {
            DataNilaiSiswa::create([
                'nilai_siswa_id' => $nilaiSiswa->id,
                'siswa_id' => $siswa[$i]['siswa_id'],
                'nilai' => $siswa[$i]['nilai'],

            ]);
        }
        return redirect()->route('NilaiSiswa.index')->with('message', 'Data Nilai Siswa Berhasil Di Tambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(NilaiSiswa $nilaiSiswa)
    {
        return Inertia::render('Guru/Nilai/Show', [
            'nilai' => NilaiSiswa::with(['kelas', 'datanilaisiswa', 'datanilaisiswa.siswa'])->find(Request::input('slug')),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NilaiSiswa $nilaiSiswa)
    {
        return Inertia::render('Guru/Nilai/Edit', [
            'nilai' => NilaiSiswa::with(['kelas', 'datanilaisiswa', 'datanilaisiswa.siswa'])->find(Request::input('slug')),
            'kelas' => Kelas::where('guru_id', Auth::user()->guru->id)->get(),
            'siswa' => Siswa::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNilaiSiswaRequest $request, NilaiSiswa $nilaiSiswa)
    {
        $siswa = $request->siswa;
        $nilaiSiswa =  NilaiSiswa::find($request->slug);
        $nilaiSiswa->update([
            'kelas_id' => $request->kelas_id,
            'tanggal' => $request->tanggal,
        ]);
        DataNilaiSiswa::where('nilai_siswa_id', $nilaiSiswa->id)->delete();
        for ($i = 0; $i < count($siswa); $i++) {
            DataNilaiSiswa::create([
                'nilai_siswa_id' => $nilaiSiswa->id,
                'siswa_id' => $siswa[$i]['siswa_id'],
                'nilai' => $siswa[$i]['nilai'],
            ]);
        }
        return redirect()->route('NilaiSiswa.index')->with('message', 'Data Nilai Siswa Berhasil Di Ubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NilaiSiswa $nilaiSiswa)
    {
        $nilai = NilaiSiswa::find(Request::input('slug'))->delete();
        return redirect()->route('NilaiSiswa.index')->with('message', 'Data Nilai Siswa Berhasil Di Hapus');
    }
}
