<?php

namespace App\Http\Controllers\Guru;

use PDF;
use Carbon\Carbon;
use App\Models\Guru;
use Inertia\Inertia;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\NilaiSiswa;
use App\Models\GaleriNilai;
use App\Models\TahunAjaran;
use App\Models\DataNilaiSiswa;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreNilaiSiswaRequest;
use App\Http\Requests\UpdateNilaiSiswaRequest;
use App\Models\DataAbsensi;

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

    public function form()
    {

        Request::validate([
            'siswa' => 'required|exists:siswas,id',
            'kelas' => 'required|exists:kelas,id',
        ]);

        return Inertia::render('Guru/Nilai/Store', [
            'kelas' => Kelas::find(Request::input('kelas')),
            'siswa' => Siswa::find(Request::input('siswa')),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */


    public function storeForm(StoreNilaiSiswaRequest $request)
    {
        $data = $request->all();
        $kelas = Kelas::find($request->kelas_id);
        $absensi_sakit = DataAbsensi::where('siswa_id', $request->siswa_id)
            ->where('tahun_ajaran', $kelas->tahun_ajaran)
            ->where('absen', 'Sakit')
            ->count();
        $absensi_tanpa_keterangan = DataAbsensi::where('siswa_id', $request->siswa_id)
            ->where('tahun_ajaran', $kelas->tahun_ajaran)
            ->where('absen', 'Tidak Hadir')
            ->count();
        $absensi_Izin = DataAbsensi::where('siswa_id', $request->siswa_id)
            ->where('tahun_ajaran', $kelas->tahun_ajaran)
            ->where('absen', 'Izin')
            ->count();
        try {
            $nilaiSiswa = NilaiSiswa::where('tanggal', $request->tanggal)->where('kelas_id', $request->kelas_id)->where('guru_id', Auth::user()->guru->id)->first();

            $pdf = PDF::loadView('pdf.laporanperkembangan', compact('data', 'absensi_sakit','absensi_tanpa_keterangan', 'absensi_Izin'))->setPaper('a4', 'potrait');

            $namaPDF = 'galeri/' . $data['nama'] . '.pdf';
            Storage::put('public/' . $namaPDF, $pdf->download()->getOriginalContent());

            if ($nilaiSiswa === null) {
                $nilaiSiswa =  NilaiSiswa::create([
                    'kelas_id' => $request->kelas_id,
                    'guru_id' => Auth::user()->guru->id,
                    'tanggal' => $request->tanggal,
                ]);
                $dataNilai = DataNilaiSiswa::create([
                    'nilai_siswa_id' => $nilaiSiswa->id,
                    'siswa_id' => $data['siswa_id'],
                    'nilai' => $namaPDF,
                ]);
            } else {
                $siswa_data = DataNilaiSiswa::where('nilai_siswa_id', $nilaiSiswa->id)->where('siswa_id', $data['siswa_id'])->get();
                if ($siswa_data->count() < 1) {


                    $dataNilai = DataNilaiSiswa::create([
                        'nilai_siswa_id' => $nilaiSiswa->id,
                        'siswa_id' => $data['siswa_id'],
                        'nilai' => $namaPDF,
                    ]);
                }
            }

            return redirect()->route('NilaiSiswa.index')->with('message', 'Data Nilai Siswa Berhasil Di Tambah');
        } catch (\Throwable $th) {
            return redirect()->route('NilaiSiswa.index')->with('message', $th->getMessage());
        }
    }
    public function store(StoreNilaiSiswaRequest $request)
    {
        $nilai = $request->all();
        $siswa = $request->siswa;
        $image = $request->image;

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

        for ($i = 0; $i < count($image); $i++) {
            $file = $image[$i];

            // Nama File
            $nameFile = md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/galeri', $nameFile);

            // Simpan Data
            $galeriSiswa = GaleriNilai::create([
                'nilai_id' => $nilaiSiswa->id,
                'image' => $nameFile,
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
            'nilai' => NilaiSiswa::with(['kelas', 'datanilaisiswa', 'datanilaisiswa.siswa', 'galeriNilai'])->find(Request::input('slug')),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NilaiSiswa $nilaiSiswa)
    {
        return Inertia::render('Guru/Nilai/Edit', [
            'nilai' => NilaiSiswa::with(['kelas', 'datanilaisiswa', 'datanilaisiswa.siswa', 'galeriNilai'])->find(Request::input('slug')),
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
