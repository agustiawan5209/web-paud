<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Kelas;
use App\Models\JadwalKegiatan;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\Http\Requests\StoreJadwalKegiatanRequest;
use App\Http\Requests\UpdateJadwalKegiatanRequest;

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
        $columns[] = 'nama_kelas';
        $columns[] = 'nama_kegiatan';
        $columns[] = 'jam';
        $columns[] = 'tanggal';
        $columns[] = 'penanggung_jawab';
        // $columns[] = 'jumlah_anak';

        return Inertia::render('Admin/Jadwal/Index', [
            'search' =>  Request::input('search'),
            'table_colums' => array_values(array_diff($columns, ['remember_token', 'kelas_id', 'password', 'email_verified_at', 'created_at', 'updated_at', 'user_id', 'deskripsi'])),
            'jadwal' => JadwalKegiatan::filterByOrder(Request::input('order'))
            ->filterBySearch(Request::input('search'))
            ->filterByRole(Request::input('order'))
            ->filterByDate(Request::input('date'))
            ->when(Request::input('kelas_id'), function ($query) {
                $query->where('kelas_id', Request::input('kelas_id'));
            })
            ->paginate(10),
            'kelas'=>Kelas::all(),
            'can'=>[
                'add'=> Auth::user()->can('add siswa'),
                'edit'=> false,
                'show'=> Auth::user()->can('show siswa'),
                'delete'=> Auth::user()->can('delete siswa'),
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Jadwal/Form', [
            'user'=> User::role('Guru')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJadwalKegiatanRequest $request)
    {
        $data = $request->all();
        // dd($data);
        $jadwalkegiatan = JadwalKegiatan::create($request->all());
        return redirect()->route('Jadwal.index')->with('message', 'data jadwal imunisasi berhasil di tambah!!!');
    }

    /**
     * Display the specified resource.
     */
    public function show(JadwalKegiatan $jadwalkegiatan)
    {
        Request::validate([
            'slug'=> 'required|exists:jadwal_kegiatans,id',
        ]);
        return Inertia::render('Admin/Jadwal/Show', [
            'jadwal'=> JadwalKegiatan::find(Request::input('slug'))
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JadwalKegiatan $jadwalkegiatan)
    {
        Request::validate([
            'slug'=> 'required|exists:jadwal_kegiatans,id',
        ]);
        $jadwalkegiatan = JadwalKegiatan::find(Request::input('slug'));
        return Inertia::render('Admin/Jadwal/Edit', [
            'user'=> User::role('Guru')->get(),
            'jadwal'=> $jadwalkegiatan,
            'kelas'=> Kelas::find($jadwalkegiatan->kelas_id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJadwalKegiatanRequest $request, JadwalKegiatan $jadwalkegiatan)
    {
        $jadwalkegiatan = JadwalKegiatan::find($request->slug)->update($request->all());
        return redirect()->route('Jadwal.index')->with('message', 'data jadwal imunisasi berhasil di Update!!!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JadwalKegiatan $jadwalkegiatan)
    {
        $jadwalkegiatan = JadwalKegiatan::find(Request::input('slug'))->delete();
        return redirect()->route('Jadwal.index')->with('message', 'data jadwal imunisasi berhasil di Hapus!!!');
    }




}
