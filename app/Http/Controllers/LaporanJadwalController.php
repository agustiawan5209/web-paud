<?php

namespace App\Http\Controllers;

use App\Models\JadwalKegiatan;
use App\Models\Kelas;
use Illuminate\Support\Facades\Request;
use PDF;


class LaporanJadwalController extends Controller
{
    public function cetak(){
        // Ambil data jadwal berdasarkan id
        $data = JadwalKegiatan::filterByDate(Request::input('date'))->get();
        $jadwal = JadwalKegiatan::filterByDate(Request::input('date'))->first();
        $kelas = Kelas::find($jadwal->kelas_id);


        // Load view untuk PDF dan pass data jadwal
        $pdf = PDF::loadView('pdf.jadwal', compact('data', 'kelas'));

        // Unduh PDF
        return $pdf->stream('jadwal.pdf');
    }
}
