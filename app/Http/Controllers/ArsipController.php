<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SuratMasuk;
use App\SuratKeluar;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ArsipExport;

class ArsipController extends Controller
{
    public function index(Request $request)
    {
        // Validasi diubah, jenis_surat sekarang wajib
        $request->validate([
            'bulan' => 'nullable|numeric|min:1|max:12|required_with:tahun',
            'tahun' => 'nullable|numeric|digits:4|required_with:bulan',
            'jenis_surat' => 'nullable|string|in:surat_masuk,surat_keluar',
        ]);

        $arsip = $this->getArsipData($request);

        return view('arsip.index', [
            'arsip' => $arsip,
            'input' => $request->all()
        ]);
    }

    public function exportPdf(Request $request)
    {
        $arsip = $this->getArsipData($request);
        $input = $request->all();

        $bulan = $input['bulan'] ?? '';
        $tahun = $input['tahun'] ?? '';
        $judul = "Laporan Arsip Surat";
        if($bulan && $tahun) {
            Carbon::setLocale('id');
            $namaBulan = Carbon::create()->month($bulan)->translatedFormat('F');
            $judul .= " Bulan " . $namaBulan . " Tahun " . $tahun;
        }

        $pdf = Pdf::loadView('arsip.arsip_pdf', compact('arsip', 'judul'));
        $pdf->setPaper('a4', 'landscape');
        return $pdf->stream('laporan-arsip.pdf');
    }

    public function exportExcel(Request $request)
    {
        $arsip = $this->getArsipData($request);
        $jenisSurat = $request->input('jenis_surat');

        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        $filename = 'laporan-' . $jenisSurat . '-' . ($bulan ?? 'semua') . '-' . ($tahun ?? 'semua') . '.xlsx';

        return Excel::download(new ArsipExport($arsip, $jenisSurat, $bulan, $tahun), $filename);
    }

    private function getArsipData(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        // Nilai default dihapus, sekarang akan null jika tidak dipilih
        $jenisSurat = $request->input('jenis_surat');

        $querySuratMasuk = SuratMasuk::query();
        $querySuratKeluar = SuratKeluar::query();

        if ($bulan && $tahun) {
            $querySuratMasuk->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
            $querySuratKeluar->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
        }

        $suratMasuk = collect();
        // ======================================================
        // PERUBAHAN DI SINI: Kondisi '|| $jenisSurat === 'semua'' dihapus
        // ======================================================
        if ($jenisSurat === 'surat_masuk') {
            $suratMasuk = $querySuratMasuk->latest('tanggal')->get()->map(function ($item) {
                $item->jenis = 'Surat Masuk';
                return $item;
            });
        }

        $suratKeluar = collect();
        // ======================================================
        // PERUBAHAN DI SINI: Kondisi '|| $jenisSurat === 'semua'' dihapus
        // ======================================================
        if ($jenisSurat === 'surat_keluar') {
            $suratKeluar = $querySuratKeluar->latest('tanggal')->get()->map(function ($item) {
                $item->jenis = 'Surat Keluar';
                return $item;
            });
        }

        // Jika tidak ada jenis surat yang dipilih, kembalikan koleksi kosong
        if (!$jenisSurat) {
            return collect();
        }

        return $suratMasuk->concat($suratKeluar)->sortByDesc('tanggal');
    }
}
