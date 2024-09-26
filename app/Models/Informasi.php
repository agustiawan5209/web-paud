<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Informasi extends Model
{
    use HasFactory;
    protected $table = 'informasis';
    protected $fillable = [
        'nama_informasi',
        'kepala_informasi',
        'nip',
        'foto_profile' ,
        'alamat',
        'logo' ,
        'visi',
        'misi',
        'deskripsi',
    ];

    protected $appends = [
        'profile_url',
        'logo_url',
    ];

    public function profileUrl() : Attribute
    {
        return new Attribute(
            get: fn()=> asset('storage/'. $this->foto_profile),
        );
    }
    public function logoUrl() : Attribute
    {
        return new Attribute(
            get: fn()=> asset('storage/'. $this->logo),
        );
    }
}
