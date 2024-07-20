<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrangTua extends Model
{
    use HasFactory;
    protected $table = 'orang_tuas';

    protected $fillable = [
        'nama',
        'user_id',
        'alamat',
        'no_telpon',
    ];

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'org_tua_id', 'id'); // Asumsikan tabel 'siswa'
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    protected $casts = [];


    protected $appends = [
        'jumlah_siswa',
    ];

    public function jumlahSiswa(): Attribute
    {
        return new Attribute(
            get: fn () => $this->siswa()->count(),
            set: fn () => 0
        );
    }




    //  FIlter Data User
    public function scopeFilter($query, $filter)
    {
        $query->when($filter['search'] ?? null, function ($query, $search) {
            $query->where('nama', 'like', '%' . $search . '%')
                ->orWhere('alamat', 'like', '%' . $search . '%')
                ->orWhere('no_telpon', 'like', '%' . $search . '%');
        })->when($filter['order'] ?? null, function ($query, $order) {
            $query->orderBy('id', $order);
        });
    }
}
