<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataAbsensi extends Model
{
    use HasFactory;

    protected $table = 'data_absensis';

    protected $fillable = [
        'absensi_id',
        'siswa_id',
        'absen',
        'tahun_ajaran',
    ];

    public function siswa(){
        return $this->hasOne(Siswa::class,'id','siswa_id');
    }

    public function absensi(){
        return $this->hasOne(Absensi::class,'id','absensi_id');
    }

     //  FIlter Data User
     public function scopeFilter($query, $filter)
     {
         $query->when($filter['search'] ?? null, function ($query, $search) {
             $query->where('absen', 'like', '%' . $search . '%');
         })->when($filter['order'] ?? null, function ($query, $order) {
             $query->orderBy('id', $order);
         });
     }
}
