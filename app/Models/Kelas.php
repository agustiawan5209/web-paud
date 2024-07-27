<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;


    protected $table = "kelas";

    protected $fillable = ['kode','keterangan', 'tahun_ajaran', 'guru_id', 'guru'];


    public function absen(){
        return $this->hasMany(Absensi::class,'kelas_id', 'id');
    }
    public function kelassiswa(){
        return $this->hasMany(KelasSiswa::class,'kelas_id', 'id');
    }

    public function scopeFilter($query, $filter)
    {
        $query->when($filter['search'] ?? null, function ($query, $search) {
            $query->where('keterangan', 'like', '%' . $search . '%')
                ->orWhere('kode', 'like', '%' . $search . '%');
        })->when($filter['order'] ?? null, function ($query, $order) {
            $query->orderBy('id', $order);
        });
    }
}
