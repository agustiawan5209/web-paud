<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Kelas;
use App\Models\JadwalHarian;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\Http\Requests\StoreJadwalHarianRequest;
use App\Http\Requests\UpdateJadwalHarianRequest;

class JadwalHarianController extends Controller
{
   /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tableName = 'jadwal_harians'; // Ganti dengan nama tabel yang Anda inginkan
        // $columns = DB::getSchemaBuilder()->getColumnListing($tableName);
        $columns[] = 'id';
        $columns[] = 'nama_kelas';
        $columns[] = 'nama_kegiatan';
        $columns[] = 'jam';
        $columns[] = 'tgl';
        $columns[] = 'penanggung_jawab';
        // $columns[] = 'jumlah_anak';

        return Inertia::render('Admin/JadwalHarian/Index', [
            'search' =>  Request::input('search'),
            'table_colums' => array_values(array_diff($columns, ['remember_token', 'kelas_id', 'password', 'email_verified_at', 'created_at', 'updated_at', 'user_id', 'deskripsi'])),
            'jadwal' => JadwalHarian::filterByOrder(Request::input('order'))
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
        return Inertia::render('Admin/JadwalHarian/Form', [
            'user'=> User::role('Guru')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJadwalHarianRequest $request)
    {
        $data = $request->all();
        // dd($data);
        $jadwalkegiatan = JadwalHarian::create($request->all());
        return redirect()->route('JadwalHarian.index')->with('message', 'data jadwal imunisasi berhasil di tambah!!!');
    }

    /**
     * Display the specified resource.
     */
    public function show(JadwalHarian $jadwalkegiatan)
    {
        Request::validate([
            'slug'=> 'required|exists:jadwal_harians,id',
        ]);
        return Inertia::render('Admin/JadwalHarian/Show', [
            'jadwal'=> JadwalHarian::find(Request::input('slug'))
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JadwalHarian $jadwalkegiatan)
    {
        Request::validate([
            'slug'=> 'required|exists:jadwal_harians,id',
        ]);
        $jadwalkegiatan = JadwalHarian::find(Request::input('slug'));
        return Inertia::render('Admin/JadwalHarian/Edit', [
            'user'=> User::role('Guru')->get(),
            'jadwal'=> $jadwalkegiatan,
            'kelas'=> Kelas::find($jadwalkegiatan->kelas_id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJadwalHarianRequest $request, JadwalHarian $jadwalkegiatan)
    {
        $jadwalkegiatan = JadwalHarian::find($request->slug)->update($request->all());
        return redirect()->route('JadwalHarian.index')->with('message', 'data jadwal imunisasi berhasil di Update!!!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JadwalHarian $jadwalkegiatan)
    {
        $jadwalkegiatan = JadwalHarian::find(Request::input('slug'))->delete();
        return redirect()->route('JadwalHarian.index')->with('message', 'data jadwal imunisasi berhasil di Hapus!!!');
    }




}
