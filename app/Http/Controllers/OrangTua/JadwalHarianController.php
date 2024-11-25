<?php

namespace App\Http\Controllers\OrangTua;

use Inertia\Inertia;
use App\Models\JadwalHarian;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class JadwalHarianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tableName = 'jadwal_kegiatans'; // Ganti dengan nama tabel yang Anda inginkan
        // $columns = DB::getSchemaBuilder()->getColumnListing($tableName);
        $columns[] = 'id';
        $columns[] = 'nama_kegiatan';
        // $columns[] = 'kelass';
        $columns[] = 'nama_siswa';
        $columns[] = 'tanggal_kegiatan';
        // $columns[] = 'penanggung_jawab';
        // $columns[] = 'jumlah_anak';
        $jadwal = JadwalHarian::filter(Request::only('search', 'order'))
            ->with(['kelas', 'kelassiswa', 'kelassiswa.siswa', 'kelassiswa.siswa.orangtua'])
            ->whereHas('kelassiswa', function ($query) {
                $query->whereHas('siswa', function ($query) {
                    $query->when(Auth::check() ? in_array('Orang Tua', Auth::user()->getRoleNames()->toArray()) ?? null : null, function ($query) {
                        $query->where('org_tua_id', '=', Auth::user()->orangtua->id);
                    });
                });
            })
            // ->join('kelas', 'jadwal_kegiatans.kelas_id', '=', 'kelas.id')
            // ->join('kelas_siswas', 'jadwal_kegiatans.kelas_id', '=', 'kelas_siswas.kelas_id')
            // ->join('siswas', 'kelas_siswas.siswa_id', '=', 'siswas.id')
            // ->select('jadwal_kegiatans.id',  'kelas.kode as nama_kelas', 'jadwal_kegiatans.start_date as tanggal_kegiatan')
            ->paginate(10);
        // dd($jadwal);
        return Inertia::render('OrangTua/JadwalHarian/Index', [
            'search' =>  Request::input('search'),
            'table_colums' => array_values(array_diff($columns, ['remember_token', 'kelas_id', 'password', 'email_verified_at', 'created_at', 'updated_at', 'user_id', 'deskripsi'])),
            'jadwal' => $jadwal,
            'can' => [
                'add' => Auth::user()->can('add siswa'),
                'edit' => Auth::user()->can('edit siswa'),
                'show' => Auth::user()->can('show siswa'),
                'delete' => Auth::user()->can('delete siswa'),
            ]
        ]);
    }

    public function show(JadwalHarian $jadwalkegiatan)
    {
        Request::validate([
            'slug'=> 'required|exists:jadwal_harians,id',
        ]);
        return Inertia::render('Admin/JadwalHarian/Show', [
            'jadwal'=> JadwalHarian::find(Request::input('slug'))
        ]);
    }
}
