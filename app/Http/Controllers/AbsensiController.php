<?php

namespace App\Http\Controllers;

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
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tableName = 'kelas'; // Ganti dengan nama tabel yang Anda inginkan
        $columns = DB::getSchemaBuilder()->getColumnListing($tableName);

        return Inertia::render('Guru/Absen/Index', [
            'search' =>  Request::input('search'),
            'table_colums' => array_values(array_diff($columns, ['remember_token', 'guru_id', 'password', 'email_verified_at', 'created_at', 'updated_at', 'user_id'])),
            'data' => Kelas::filter(Request::only('search', 'order'))
                ->where('guru_id', Auth::user()->guru->id)
                ->paginate(10),
            'can' => [
                'form' => Auth::user()->can('form absen'),
                'add' => Auth::user()->can('add absen'),
                'edit' => Auth::user()->can('edit kelas'),
                'show' => false,
                'delete' => Auth::user()->can('delete kelas'),
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
        $valid = Validator::make(Request::all(), [
            'item' => 'required|string|max:30',
            'slug' => 'required|exists:kelas,id',
        ]);

        if ($valid->fails()) {
            return redirect()->back()->with('message', 'Gagal Data Kelas Hilang');
        }
        $absen = Absensi::where('kelas_id', Request::input('slug'))->where('tanggal', Carbon::now()->format('Y-m-d'))->get();

        if ($absen->count() > 0) {
            return redirect()->back()->with('message', ' Data Absen Telah Tersedia Hilang');
        }
        return Inertia::render('Guru/Absen/Form', [
            'kelas' => Kelas::with(['absen', 'kelassiswa'])->find(Request::input('slug')),
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

        for ($i = 0; $i < count($siswa); $i++) {
            Absensi::create([
                'kelas_id' => $request->kelas_id,
                'siswa_id' => $siswa[$i]['siswa_id'],
                'guru_id'=> Auth::user()->guru->id,
                'tanggal' => $request->tanggal,
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
            'absen' => Absensi::with(['kelas', 'siswa'])->find(Request::input('slug')),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Absensi $absensi)
    {
        return Inertia::render('Guru/Absen/Edit', [
            'absen' => Absensi::with(['kelas', 'siswa'])->find(Request::input('slug')),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAbsensiRequest $request, Absensi $absensi)
    {
        $absen = Absensi::find(Request::input('slug'))->update($request->all);
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
