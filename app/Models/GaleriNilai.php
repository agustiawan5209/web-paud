<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GaleriNilai extends Model
{
    use HasFactory;

    protected $table = 'galeri_nilais';

    protected $fillable = [
        'nilai_id',
        'image',
    ];

    public function nilaiSiswa(){
        return $this->hasOne(NilaiSiswa::class, 'id','nilai_id');
    }

    protected $appends = [
        'image_path',
    ];

    public function imagePath(): Attribute
    {
        return new Attribute(
            get: fn()=> asset('storage/galeri/'. $this->image),
            set: null,
        );
    }
}
