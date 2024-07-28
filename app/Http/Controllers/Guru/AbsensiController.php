<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use Inertia\Inertia;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Absensi;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\Http\Requests\StoreAbsensiRequest;
use App\Http\Requests\UpdateAbsensiRequest;
use App\Models\DataAbsensi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tableName = 'absensis'; // Ganti dengan nama tabel yang Anda inginkan
        // $columns = DB::getSchemaBuilder()->getColumnListing($tableName);
        $columns[] = 'id';
        $columns[] = 'tanggal';
        $columns[] = 'nama_kelas';
        return Inertia::render('Guru/Absen/Index', [
            'search' =>  Request::input('search'),
            'table_colums' => array_values(array_diff($columns, ['remember_token', 'kelas_id', 'guru_id', 'password', 'email_verified_at', 'created_at', 'updated_at', 'user_id'])),
            'data' => Absensi::filter(Request::only('search', 'order'))
                ->with(['kelas', 'dataabsensi'])
                ->where('guru_id', Auth::user()->guru->id)
                ->paginate(10),
            'can' => [
                // 'form' => Auth::user()->can('form absen'),
                'add' => Auth::user()->can('add absen'),
                'edit' => Auth::user()->can('edit absen'),
                'show' => Auth::user()->can('show absen'),
                'delete' => Auth::user()->can('delete absen'),
                'reset' => Auth::user()->can('reset absen'),
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

        return Inertia::render('Guru/Absen/Form', [
            'kelas' => Kelas::where('guru_id', Auth::user()->guru->id)->get(),
            'siswa' => Siswa::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAbsensiRequest $request)
    {
        $absen = $request->all();
        $siswa = $request->siswa;
        $absensi =  Absensi::create([
            'kelas_id' => $request->kelas_id,
            'guru_id' => Auth::user()->guru->id,
            'tanggal' => $request->tanggal,
        ]);
        for ($i = 0; $i < count($siswa); $i++) {


            DataAbsensi::create([
                'absensi_id' => $absensi->id,
                'siswa_id' => $siswa[$i]['siswa_id'],
                'absen' => $siswa[$i]['absen'],

            ]);
        }
        return redirect()->route('Absen.index')->with('message', 'Data Absen Berhasil Di Tambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(Absensi $absensi)
    {
        return Inertia::render('Guru/Absen/Show', [
            'absen' => Absensi::with(['kelas', 'dataabsensi', 'dataabsensi.siswa'])->find(Request::input('slug')),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Absensi $absensi)
    {
        return Inertia::render('Guru/Absen/Edit', [
            'absen' => Absensi::with(['kelas', 'dataabsensi', 'dataabsensi.siswa'])->find(Request::input('slug')),
            'kelas' => Kelas::where('guru_id', Auth::user()->guru->id)->get(),
            'siswa' => Siswa::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAbsensiRequest $request, Absensi $absensi)
    {
        $siswa = $request->siswa;
        $absensi =  Absensi::find($request->slug);
        $absensi->update([
            'kelas_id' => $request->kelas_id,
            'tanggal' => $request->tanggal,
        ]);
        DataAbsensi::where('absensi_id', $absensi->id)->delete();
        for ($i = 0; $i < count($siswa); $i++) {
            DataAbsensi::create([
                'absensi_id' => $absensi->id,
                'siswa_id' => $siswa[$i]['siswa_id'],
                'absen' => $siswa[$i]['absen'],
            ]);
        }
        return redirect()->route('Absen.index')->with('message', 'Data Absen Berhasil Di Ubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Absensi $absensi)
    {
        $absen = Absensi::find(Request::input('slug'))->delete();
        return redirect()->route('Absen.index')->with('message', 'Data Absen Berhasil Di Hapus');
    }
}
