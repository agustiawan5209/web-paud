<?php

namespace App\Http\Controllers\Guru;

use Carbon\Carbon;
use App\Models\Guru;
use Inertia\Inertia;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\DataAbsensi;
use App\Models\TahunAjaran;
use App\Models\PerkembanganSiswa;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\DataPerkembanganSiswa;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StorePerkembanganSiswaRequest;
use App\Http\Requests\UpdatePerkembanganSiswaRequest;
use PDF;
class PerkembanganSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tableName = 'perkembangan_siswas'; // Ganti dengan nama tabel yang Anda inginkan
        // $columns = DB::getSchemaBuilder()->getColumnListing($tableName);
        $columns[] = 'id';
        $columns[] = 'tanggal';
        $columns[] = 'nama_kelas';
        return Inertia::render('Guru/Perkembangan/Index', [
            'search' =>  Request::input('search'),
            'table_colums' => array_values(array_diff($columns, ['remember_token', 'kelas_id', 'guru_id', 'password', 'email_verified_at', 'created_at', 'updated_at', 'user_id'])),
            'data' => PerkembanganSiswa::filter(Request::only('search', 'order'))
                ->with(['kelas', 'dataperkembangansiswa'])
                ->where('guru_id', Auth::user()->guru->id)
                ->paginate(10),
            'can' => [
                // 'form' => Auth::user()->can('form perkembangan'),
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

        return Inertia::render('Guru/Perkembangan/Form', [
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

        return Inertia::render('Guru/Perkembangan/Store', [
            'kelas' => Kelas::find(Request::input('kelas')),
            'siswa' => Siswa::find(Request::input('siswa')),
        ]);
    }

    public function storeForm(StorePerkembanganSiswaRequest $request)
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
            $perkembanganSiswa = PerkembanganSiswa::where('tanggal', $request->tanggal)->where('kelas_id', $request->kelas_id)->where('guru_id', Auth::user()->guru->id)->first();

            $pdf = PDF::loadView('pdf.laporanperkembangan', compact('data', 'absensi_sakit','absensi_tanpa_keterangan', 'absensi_Izin'))->setPaper('a4', 'potrait');

            $namaPDF = 'galeri/' . $data['nama'] . '.pdf';
            Storage::put('public/' . $namaPDF, $pdf->download()->getOriginalContent());

            if ($perkembanganSiswa === null) {
                $perkembanganSiswa =  PerkembanganSiswa::create([
                    'kelas_id' => $request->kelas_id,
                    'guru_id' => Auth::user()->guru->id,
                    'tanggal' => $request->tanggal,
                ]);
                $dataNilai = DataPerkembanganSiswa::create([
                    'perkembangan_siswa_id' => $perkembanganSiswa->id,
                    'siswa_id' => $data['siswa_id'],
                    'perkembangan' => $namaPDF,
                ]);
            } else {
                $siswa_data = DataPerkembanganSiswa::where('perkembangan_siswa_id', $perkembanganSiswa->id)->where('siswa_id', $data['siswa_id'])->get();
                if ($siswa_data->count() < 1) {

                    $dataNilai = DataPerkembanganSiswa::create([
                        'perkembangan_siswa_id' => $perkembanganSiswa->id,
                        'siswa_id' => $data['siswa_id'],
                        'perkembangan' => $namaPDF,
                    ]);
                }else{
            return redirect()->route('Perkembangan.index')->with('message', 'Laporan Perkembangan Siswa Telah Ada');

                }
            }

            return redirect()->route('Perkembangan.index')->with('message', 'Data Perkembangan Siswa Berhasil Di Tambah');
        } catch (\Throwable $th) {
            return redirect()->route('Perkembangan.index')->with('message', $th->getMessage());
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePerkembanganSiswaRequest $request)
    {
        $perkembangan = $request->all();
        $siswa = $request->siswa;
        $perkembanganSiswa =  PerkembanganSiswa::create([
            'kelas_id' => $request->kelas_id,
            'guru_id' => Auth::user()->guru->id,
            'tanggal' => $request->tanggal,
        ]);
        for ($i = 0; $i < count($siswa); $i++) {
            DataPerkembanganSiswa::create([
                'perkembangan_siswa_id' => $perkembanganSiswa->id,
                'siswa_id' => $siswa[$i]['siswa_id'],
                'perkembangan' => $siswa[$i]['perkembangan'],

            ]);
        }
        return redirect()->route('Perkembangan.index')->with('message', 'Data Nilai Siswa Berhasil Di Tambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(PerkembanganSiswa $perkembanganSiswa)
    {
        return Inertia::render('Guru/Perkembangan/Show', [
            'perkembangan' => PerkembanganSiswa::with(['kelas', 'dataperkembangansiswa', 'dataperkembangansiswa.siswa'])->find(Request::input('slug')),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PerkembanganSiswa $perkembanganSiswa)
    {
        return Inertia::render('Guru/Perkembangan/Edit', [
            'perkembangan' => PerkembanganSiswa::with(['kelas', 'dataperkembangansiswa', 'dataperkembangansiswa.siswa'])->find(Request::input('slug')),
            'kelas' => Kelas::where('guru_id', Auth::user()->guru->id)->get(),
            'siswa' => Siswa::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePerkembanganSiswaRequest $request, PerkembanganSiswa $perkembanganSiswa)
    {
        $siswa = $request->siswa;
        $perkembanganSiswa =  PerkembanganSiswa::find($request->slug);
        $perkembanganSiswa->update([
            'kelas_id' => $request->kelas_id,
            'tanggal' => $request->tanggal,
        ]);
        DataPerkembanganSiswa::where('perkembangan_siswa_id', $perkembanganSiswa->id)->delete();
        for ($i = 0; $i < count($siswa); $i++) {
            DataPerkembanganSiswa::create([
                'perkembangan_siswa_id' => $perkembanganSiswa->id,
                'siswa_id' => $siswa[$i]['siswa_id'],
                'perkembangan' => $siswa[$i]['perkembangan'],
            ]);
        }
        return redirect()->route('Perkembangan.index')->with('message', 'Data Nilai Siswa Berhasil Di Ubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PerkembanganSiswa $perkembanganSiswa)
    {
        $perkembangan = PerkembanganSiswa::find(Request::input('slug'))->delete();
        return redirect()->route('Perkembangan.index')->with('message', 'Data Nilai Siswa Berhasil Di Hapus');
    }
}
