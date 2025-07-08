<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Menampilkan jml srt masuk keseluruhan, jml keluar keseluruhan, total seluruh surat
    // , jml per bulan
    public function index()
    {
        $jumlahSuratMasuk = SuratMasuk::count();
        $jumlahSuratKeluar = SuratKeluar::count();
        $totalSurat = $jumlahSuratMasuk + $jumlahSuratKeluar;


        $suratMasukTerbaru = SuratMasuk::latest()->take(5)->get();
        $suratKeluarTerbaru = SuratKeluar::latest()->take(5)->get();


        $bulanIni = now()->month;

        if (request()->filled('filter_bulan')) {
            [$tahun, $bulan] = explode('-', request('filter_bulan'));
        } else {
            $tahun = now()->year;
            $bulan = now()->month;
        }

        $suratMasukBulanIni = SuratMasuk::whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->count();

        $suratKeluarBulanIni = SuratKeluar::whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->count();

        return view('dashboard', compact(
            'jumlahSuratMasuk',
            'jumlahSuratKeluar',
            'totalSurat',
            'suratMasukBulanIni',
            'suratKeluarBulanIni',
            'suratMasukTerbaru',
            'suratKeluarTerbaru'
        ));
    }
}