<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPerkembanganSiswa extends Model
{
    use HasFactory;

    protected $table = 'data_perkembangan_siswas';

    protected $fillable = [
        'perkembangan_siswa_id',
        'siswa_id',
        'perkembangan',
    ];

    public function siswa(){
        return $this->hasOne(Siswa::class,'id','siswa_id');
    }
    public function perkembangansiswa(){
        return $this->hasOne(PerkembanganSiswa::class,'id','perkembangan_siswa_id');
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
