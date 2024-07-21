<?php

namespace App\Models;

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
