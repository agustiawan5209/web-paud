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
        $jadwal = JadwalKegiatan::find(Request::input('slug'));
        $kelas = Kelas::find($jadwal->kelas_id);


        // Load view untuk PDF dan pass data jadwal
        $pdf = PDF::loadView('pdf.jadwal', compact('jadwal', 'kelas'))->setPaper('a4', 'landscape');

        // Unduh PDF
        return $pdf->stream('jadwal.pdf');
    }
}
