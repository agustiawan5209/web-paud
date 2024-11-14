<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\GuruController;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\OrangTua;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $guru = 0;
        $kelas = 0;
        $user = User::with(['orangtua'])->find(Auth::user()->id);
        if (in_array('Admin', Auth::user()->getRoleNames()->toArray())) {
            $guru = Guru::when(Auth::check() ? in_array('Orang Tua', Auth::user()->getRoleNames()->toArray()) ?? null : null, function ($query) {
                $query->where('org_tua_id', '=', Auth::user()->orangtua->id);
            })->get()->count();
            $kelas = Kelas::all()->count();
        }

        if (in_array('Guru', Auth::user()->getRoleNames()->toArray())) {
            $kelas = Kelas::when(in_array('Guru', Auth::user()->getRoleNames()->toArray()) ?? null, function ($query) {
                $query->where('guru_id', '=', Auth::user()->guru->id);
            })->get()->count();
        }
        return Inertia::render('Dashboard', [
            'guru' => $guru,
            'siswa' => Siswa::when(Auth::check() ? in_array('Orang Tua', Auth::user()->getRoleNames()->toArray()) ?? null : null, function ($query) {
                $query->where('org_tua_id', '=', Auth::user()->orangtua->id);
            })->get()->count(),
            'kelas'=> $kelas,
            'orangtua'=> OrangTua::all()->count(),
        ]);
    }
}
