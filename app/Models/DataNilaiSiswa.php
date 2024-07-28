<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataNilaiSiswa extends Model
{
    use HasFactory;

    protected $table = 'data_nilai_siswas';

    protected $fillable = [
        'nilai_siswa_id',
        'siswa_id',
        'nilai',
    ];

    public function siswa(){
        return $this->hasOne(Siswa::class,'id','siswa_id');
    }

     //  FIlter Data User
     public function scopeFilter($query, $filter)
     {
         $query->when($filter['search'] ?? null, function ($query, $search) {
             $query->where('nilai', 'like', '%' . $search . '%');
         })->when($filter['order'] ?? null, function ($query, $order) {
             $query->orderBy('id', $order);
         });
     }
}
