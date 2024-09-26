<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Informasi;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreInformasiRequest;
use App\Http\Requests\UpdateInformasiRequest;

class InformasiController extends Controller
{
    /**
     * Tampilan daftar Informasi
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $informasis = Informasi::all();
        return Inertia::render('Setting/index', ['informasi' => $informasis]);
    }

    /**
     * Tampilan form pembuatan Informasi baru
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Setting/Update', [
            'informasi' => Informasi::find(1),
        ]);
    }

    /**
     * Menyimpan data Informasi baru
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInformasiRequest $request)
    {
        $validatedData = $request->all();
        $informasis = Informasi::find(1);

        // Foto Profile
        $file_logo = null;
        $file_foto_profile = null;

        if ($informasis != null) {
            $file_logo = $informasis->logo;
            $file_foto_profile = $informasis->foto_profile;
        }
        if ($request->file('foto_profile') != null) {
            $this->destroyFotoProfile();
            $nama_foto_profile = $request->file('foto_profile')->getClientOriginalName();
            $ext_foto_profile = $request->file('foto_profile')->getClientOriginalExtension();
            $file_foto_profile = 'informasi/' . md5($nama_foto_profile) . '.' . $ext_foto_profile;
            $request->file('foto_profile')->storeAs('public/', $file_foto_profile);
        }

        // Logo
        if ($request->file('logo') != null) {
            $this->destroyLogo();
            $nama_logo = $request->file('logo')->getClientOriginalName();
            $ext_logo = $request->file('logo')->getClientOriginalExtension();
            $file_logo = 'informasi/' . md5($nama_logo) . '.' . $ext_logo;
            $request->file('logo')->storeAs('public/', $file_logo);
        }


        $validatedData['foto_profile'] = $file_foto_profile;
        $validatedData['logo'] = $file_logo;

        if ($informasis == null) {
            Informasi::create($validatedData);
        } else {
            $informasis->update($validatedData);
        }

        return redirect()->route('Setting.create')->with('message', 'Informasi baru berhasil Di Update!');
    }

    public function destroyFotoProfile()
    {
        $informasis = Informasi::find(1);
        if ($informasis !== null && $informasis->foto_profile !== null) {
            $name = $informasis->foto_profile;
            if (Storage::disk('public')->exists($name)) {
                Storage::disk('public')->delete($name);
            }
        }
    }
    public function destroyLogo()
    {
        $informasis = Informasi::find(1);
        if ($informasis !== null && $informasis->logo !== null) {
            $name = $informasis->logo;
            if (Storage::disk('public')->exists($name)) {
                Storage::disk('public')->delete($name);
            }
        }
    }
}
