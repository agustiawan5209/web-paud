<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JadwalKegiatan extends Model
{
    use HasFactory;


    protected $table = 'jadwal_kegiatans';
    protected $fillable = [
        'kelas_id',
        'start_date',
        'end_date',
        'jadwal',
        'penanggung_jawab',
    ];

    protected $casts = [
        'jadwal' => 'json',
    ];

    public function kelas()
    {
        return $this->hasOne(Kelas::class, 'id', 'kelas_id');
    }

    public function kelassiswa()
    {
        return $this->hasMany(KelasSiswa::class, 'kelas_id', 'kelas_id');
    }

    protected $appends = [
        'nama_kelas'
    ];

    public function namaKelas(): Attribute
    {
        // dd($this->kelas);
        return new Attribute(
            get: fn() => $this->kelas == null ? '--' : "Kelas =" . $this->kelas->kode . " || tahun ajaran = " . $this->kelas->tahun_ajaran,
        );
    }



    //  FIlter Data User
    public function scopeFilter($query, $filter)
    {
        $query->when($filter['search'] ?? null, function ($query, $search) {
            $query->whereDate('start_date', 'like', '%' . $search . '%')
                ->orWhere('penanggung_jawab', 'like', '%' . $search . '%');
        })->when($filter['order'] ?? null, function ($query, $order) {
            $query->orderBy('id', $order);
        });
    }

    public function scopeFilterBySearch($query, $search)
    {
        $query->when($search ?? null, function ($query, $search) {
            $query->where('penanggung_jawab', 'like', '%' . $search . '%');
        });
    }

    public function scopeFilterByOrder($query, $order)
    {
        $query->when($order ?? null, function ($query, $order) {
            $query->orderBy('id', $order);
        });
    }
    public function scopeFilterByDate($query, $date)
    {
        // Pastikan $date adalah string yang valid untuk Carbon
        $startDate = Carbon::parse($date)->format('Y-m-d');  // Tanggal awal
        $endDate = Carbon::parse($date)->addDay(7)->format('Y-m-d');  // Tanggal 7 hari setelahnya

        // Gunakan whereBetween untuk rentang tanggal
        $query->when($date ?? null, function ($query) use ($startDate, $endDate) {
            $query->whereBetween('end_date', [$startDate, $endDate]);
        });
    }
    public function scopeFilterByDateBetween($query, $date)
    {
        $query->when($date ?? null, function ($query, $date) {
            $query->whereBetween('start_date', [$date['date'], $date['end_date']]);
        });
    }

    public function scopeFilterByRole($query, $role)
    {
        $query->when(Auth::user()->hasRole('Pasien'), function ($query, $role) {
            $query->where('id_pasien', Auth::user()->pasien->id);
        });
    }
}
