<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'tgl_lahir',
        'tempat_lahir',
        'jenkel',
        'org_tua_id',
        'nama_orang_tua',
    ];

    // reation
    public function orangTua()
    {
        return $this->hasOne(OrangTua::class, 'id', 'org_tua_id');
    }

    //  FIlter Data User
    public function scopeFilter($query, $filter)
    {
        $query->when($filter['search'] ?? null, function ($query, $search) {
            $query->where('nama', 'like', '%' . $search . '%')
                ->orWhereDate('tgl_lahir', 'like', '%' . $search . '%')
                ->orWhere('jenkel', 'like', '%' . $search . '%')
                ->orWhere('tempat_lahir', 'like', '%' . $search . '%')
                ->orWhereHas('orangTua', function ($query) use ($search) {
                    $query->where('nama', 'like', '%' . $search . '%');
                });
        })->orderBy('id', $filter['order'] ?? 'desc')
        ->when(Auth::check() ? in_array('Orang Tua', Auth::user()->getRoleNames()->toArray()) ?? null : null, function ($query) {
            $query->where('org_tua_id', '=', Auth::user()->orangtua->id);
        });
    }
}
