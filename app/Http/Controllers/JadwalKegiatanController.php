<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\JadwalKegiatan;
use Illuminate\Support\Facades\DB;
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
        $columns = DB::getSchemaBuilder()->getColumnListing($tableName);
        // $columns[] = 'jumlah_anak';

        return Inertia::render('Jadwal/Index', [
            'search' =>  Request::input('search'),
            'table_colums' => array_values(array_diff($columns, ['remember_token', 'kelas_id', 'password', 'email_verified_at', 'created_at', 'updated_at', 'user_id', 'deskripsi'])),
            'data' => JadwalKegiatan::filter(Request::only('search', 'order'))
            ->paginate(10),
            'can'=>[
                'add'=> Auth::user()->can('add riwayat'),
                'edit'=> Auth::user()->can('edit riwayat'),
                'show'=> Auth::user()->can('show riwayat'),
                'delete'=> Auth::user()->can('delete riwayat'),
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Jadwal/Form', [
            'user'=> User::role('Kader')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJadwalKegiatanRequest $request)
    {
        $data = $request->all();
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
        return Inertia::render('Jadwal/Show', [
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
        return Inertia::render('Jadwal/Edit', [
            'user'=> User::role('Kader')->get(),
            'jadwal'=> JadwalKegiatan::find(Request::input('slug'))
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
