<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensis';

    protected $fillable = [
        'kelas_id',
        'siswa_id',
        'tanggal',
        'absen',
    ];

    public function kelas(){
        return $this->hasOne(Kelas::class,'id','kelas_id');
    }
    public function siswa(){
        return $this->hasOne(Siswa::class,'id','siswa_id');
    }

     //  FIlter Data User
     public function scopeFilter($query, $filter)
     {
         $query->when($filter['search'] ?? null, function ($query, $search) {
             $query->whereDate('tanggal', 'like', '%' . $search . '%')
                 ->orWhere('absen', 'like', '%' . $search . '%');
         })->when($filter['order'] ?? null, function ($query, $order) {
             $query->orderBy('id', $order);
         });
     }
}
