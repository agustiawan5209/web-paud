<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use App\Http\Requests\StoreTahunAjaranRequest;
use App\Http\Requests\UpdateTahunAjaranRequest;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class TahunAjaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render(['Admin/TahunAjar/Index']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTahunAjaranRequest $request)
    {
        TahunAjaran::create($request->all());

        return redirect()->route('TahunAjar.index')->with('message','Data Berhasil Di Tambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(TahunAjaran $tahunAjaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TahunAjaran $tahunAjaran)
    {
        return response()->json($tahunAjaran->find(Request::input('slug')), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTahunAjaranRequest $request, TahunAjaran $tahunAjaran)
    {
        TahunAjaran::find($request->slug)->update($request->all());

        return redirect()->route('TahunAjar.index')->with('message','Data Berhasil Di Tambah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TahunAjaran $tahunAjaran)
    {
        TahunAjaran::find(Request::input('slug'))->delete();

        return redirect()->route('TahunAjar.index')->with('message','Data Berhasil Di Tambah');
    }
}
