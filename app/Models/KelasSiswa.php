<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelasSiswa extends Model
{
    use HasFactory;

    protected $table = 'kelas_siswas';

    protected $fillable = [
        'kelas_id',
        'siswa_id',
        'kelas',
        'siswa',
    ];

    protected $casts = [
        'kelas'=>'json',
        'siswa'=>'json',
    ];

    protected $appends = [
        'nama_kelas',
        'nama_siswa',
    ];

    public function namaKelas():Attribute
    {
        return new Attribute(
            get: fn()=> $this->kelas['kode'],
            set: null,
        );
    }
    public function namaSiswa():Attribute
    {
        return new Attribute(
            get: fn()=> $this->siswa['nama'],
            set: null,
        );
    }

    public function kelas(){
        return $this->hasOne(Kelas::class,'id','kelas_id');
    }
    public function siswa(){
        return $this->hasOne(Siswa::class,'id','siswa_id');
    }

    public function jadwalkegiatan(){
        return $this->hasMany(Jadwalkegiatan::class,'kelas_id','kelas_id');
    }

    //  FIlter Data User
    public function scopeFilter($query, $filter)
    {
        $query->when($filter['search'] ?? null, function ($query, $search) {
            $query->where('kelas_id', 'like', '%' . $search . '%')
                ->orWhere('siswa_id', 'like', '%' . $search . '%')
                ->orWhere('kelas', 'like', '%' . $search . '%');
        })->when($filter['order'] ?? null, function ($query, $order) {
            $query->orderBy('id', $order);
        });
    }
}
