<?php

namespace App\Http\Controllers\Guru;

use Inertia\Inertia;
use App\Models\JadwalKegiatan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class JadwalKegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tableName = 'jadwal_kegiatans'; // Ganti dengan nama tabel yang Anda inginkan
        // $columns = DB::getSchemaBuilder()->getColumnListing($tableName);
        $columns[] = 'id';
        $columns[] = 'kelass';
        $columns[] = 'nama_kegiatan';
        $columns[] = 'tanggal';
        $columns[] = 'penanggung_jawab';

        $jadwal = JadwalKegiatan::filter(Request::only('search', 'order'))
            ->with(['kelas', 'kelassiswa', 'kelassiswa.siswa', 'kelassiswa.siswa.orangtua'])
            ->whereHas('kelassiswa', function ($query) {
                $query->whereHas('siswa', function ($query) {
                    $query->when(Auth::check() ? in_array('Orang Tua', Auth::user()->getRoleNames()->toArray()) ?? null : null, function ($query) {
                        $query->where('org_tua_id', '=', Auth::user()->orangtua->id);
                    });
                });
            })
            ->join('kelas', 'jadwal_kegiatans.kelas_id', '=', 'kelas.id')
            ->select('jadwal_kegiatans.id', 'nama_kegiatan', 'tanggal', 'penanggung_jawab', 'kelas.kode as kelass')
            ->paginate(10);

        return Inertia::render('OrangTua/Jadwal/Index', [
            'search' =>  Request::input('search'),
            'table_colums' => array_values(array_diff($columns, ['remember_token', 'kelas_id', 'password', 'email_verified_at', 'created_at', 'updated_at', 'user_id', 'deskripsi'])),
            'data' => $jadwal,
            'can' => [
                'add' => Auth::user()->can('add siswa'),
                'edit' => Auth::user()->can('edit siswa'),
                'show' => Auth::user()->can('show siswa'),
                'delete' => Auth::user()->can('delete siswa'),
            ]
        ]);
    }

    public function show(JadwalKegiatan $jadwalkegiatan)
    {
        Request::validate([
            'slug' => 'required|exists:jadwal_kegiatans,id',
        ]);
        return Inertia::render('Admin/Jadwal/Show', [
            'jadwal' => JadwalKegiatan::find(Request::input('slug'))
        ]);
    }
}
