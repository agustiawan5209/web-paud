<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensis';

    protected $fillable = [
        'kelas_id',
        'guru_id',
        'tanggal',
        'tahun_ajaran',
    ];

    public function kelas()
    {
        return $this->hasOne(Kelas::class, 'id', 'kelas_id');
    }
    public function dataabsensi()
    {
        return $this->hasMany(DataAbsensi::class, 'absensi_id', 'id');
    }

    protected $appends = [
        'nama_kelas',
    ];

    public function namaKelas(): Attribute
    {
        return new Attribute(
            get: fn () => $this->kelas->kode,
            set: null,
        );
    }

    //  FIlter Data User
    public function scopeFilter($query, $filter)
    {
        $query->when($filter['search'] ?? null, function ($query, $search) {
            $query->whereDate('tanggal', 'like', '%' . $search . '%')
                ->orWhereHas('kelas', function ($query) use ($search) {
                    $query->where('kode', 'like', '%' . $search . '%');
                })
                ->orWhereHas('dataabsensi', function ($query) use ($search) {
                    $query->where('absen', 'like', '%' . $search . '%');
                });
        })->when($filter['order'] ?? null, function ($query, $order) {
            $query->orderBy('id', $order);
        });
    }
}
