<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JadwalKegiatan extends Model
{
    use HasFactory;


    protected $table = 'jadwal_kegiatans';
    protected $fillable = [
        'kelas_id',
        'tanggal',
        'nama_kegiatan',
        'deskripsi',
        'penanggung_jawab',
    ];

    protected $casts = [
        // 'tanggal'=> 'date',
    ];

    protected $appends = [
        'jadwal',
    ];

    public function jadwal() : Attribute
    {
        return new Attribute(
            get: fn ()=> Carbon::parse($this->tanggal)->format('j F Y'),
        );
    }

    //  FIlter Data User
    public function scopeFilter($query, $filter)
    {
        $query->when($filter['search'] ?? null, function ($query, $search) {
            $query->where('deskripsi', 'like', '%' . $search . '%')
                ->orWhereDate('tanggal', 'like', '%' . $search . '%')
                ->orWhere('penanggung_jawab', 'like', '%' . $search . '%')
                ->orWhere('nama_kegiatan', 'like', '%' . $search . '%');
        })->when($filter['order'] ?? null, function ($query, $order) {
            $query->orderBy('id', $order);
        });
    }
}
