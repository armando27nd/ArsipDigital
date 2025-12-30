<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kategori;
use App\Arsip;
use App\SuratKeluar;
use App\SuratMasuk;
use App\Agenda;
use App\Disposisi;
use Carbon\Carbon; // Import Carbon untuk bekerja dengan tanggal

class HomeController extends Controller
{
    /**
     * Metode index untuk menampilkan dashboard dengan statistik dokumen.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Hitung total data untuk setiap model secara keseluruhan
        $jumlahsm = SuratMasuk::count();
        $jumlahsk = SuratKeluar::count();
        $jumlahagenda = Agenda::count();
        $jumlahdispo = Disposisi::count();

        // Ambil tahun saat ini
        $currentYear = Carbon::now()->year;

        // Hitung total data untuk setiap model khusus untuk tahun saat ini
        // Asumsi: Setiap model memiliki kolom 'created_at' untuk menyimpan tanggal pembuatan.
        $jumlahsmTahunIni = SuratMasuk::whereYear('created_at', $currentYear)->count();
        $jumlahskTahunIni = SuratKeluar::whereYear('created_at', $currentYear)->count();
        $jumlahagendaTahunIni = Agenda::whereYear('created_at', $currentYear)->count();
        $jumlahdispoTahunIni = Disposisi::whereYear('created_at', $currentYear)->count();

        // Kembalikan view 'home' dengan semua data yang dihitung
        return view('home', compact(
            'jumlahsm',
            'jumlahsk',
            'jumlahagenda',
            'jumlahdispo',
            'jumlahsmTahunIni', // Tambahkan ini
            'jumlahskTahunIni', // Tambahkan ini
            'jumlahagendaTahunIni', // Tambahkan ini
            'jumlahdispoTahunIni'  // Tambahkan ini
        ));
    }
}
