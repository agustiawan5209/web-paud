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
}
