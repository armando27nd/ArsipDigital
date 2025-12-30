<?php

namespace App\Http\Controllers;

use App\Agenda;
use App\Disposisi;
use App\Exports\LaporanExcel;
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Menampilkan halaman utama Laporan dengan filter dan hasil.
     * Metode ini menangani tampilan awal dan pemrosesan filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Selalu ambil daftar disposisi untuk dropdown filter
        $disposisiList = Disposisi::all();

        // Inisialisasi variabel untuk tampilan awal atau jika filter belum diterapkan
        $agendas = collect(); // Koleksi kosong untuk hasil agenda awal
        $tanggal_terpilih = null;
        $disposisi_terpilih = 'semua';

        // Cek apakah ada parameter filter dari request (saat form disubmit)
        if ($request->has('tanggal') && $request->has('disposisi_id')) {
            // Validasi input
            $request->validate([
                'tanggal' => 'required|date',
                'disposisi_id' => 'required|string',
            ]);

            // Ambil nilai filter dari request
            $tanggal_terpilih = $request->tanggal;
            $disposisi_terpilih = $request->disposisi_id;

            // Query untuk mengambil agenda berdasarkan filter
            $query = Agenda::with('disposisi')->whereDate('tanggal', $tanggal_terpilih);

            if ($disposisi_terpilih != 'semua') {
                $query->where('disposisi_id', $disposisi_terpilih);
            }

            $agendas = $query->orderBy('jam', 'asc')->get();
        }

        // Kirim semua data yang diperlukan ke view laporan.hasil
        // Ini memastikan semua variabel selalu ada saat hasil.blade.php dirender
        return view('laporan.hasil', [
            'agendas' => $agendas,
            'disposisiList' => $disposisiList,
            'tanggal_terpilih' => $tanggal_terpilih,
            'disposisi_terpilih' => $disposisi_terpilih,
        ]);
    }

    /**
     * Metode `hasil()` sebelumnya digabungkan ke dalam `index()`.
     * Anda bisa menghapus metode ini jika tidak ada route lain yang mengarah ke sana.
     *
     * public function hasil(Request $request)
     * {
     * // Logika ini sudah dipindahkan ke metode index()
     * }
     */

    /**
     * Mencetak laporan ke PDF.
     * Metode ini tetap terpisah karena fungsinya spesifik untuk generate PDF.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function pdf(Request $request)
    {
        // Pastikan validasi juga dilakukan di sini jika metode ini bisa diakses langsung
        // tanpa melalui form hasil yang sudah divalidasi.
        $request->validate([
            'tanggal' => 'required|date',
            'disposisi_id' => 'required|string',
        ]);

        $tanggal = $request->tanggal;
        $disposisiId = $request->disposisi_id;

        $query = Agenda::with('disposisi')->whereDate('tanggal', $tanggal);

        if ($disposisiId != 'semua') {
            $query->where('disposisi_id', $disposisiId);
        }

        $agendas = $query->orderBy('jam', 'asc')->get();

        $nama_filter = 'Semua Disposisi';
        if ($disposisiId != 'semua') {
            $disposisiModel = Disposisi::find($disposisiId);
            $nama_filter = $disposisiModel ? $disposisiModel->perihal : 'Tidak Diketahui';
        }

        return view('laporan.print', [
            'agendas' => $agendas,
            'tanggal' => $tanggal,
            'nama_filter_disposisi' => $nama_filter,
        ]);
    }

    public function excel(Request $request)
    {
        // Pastikan validasi juga dilakukan di sini jika metode ini bisa diakses langsung
        // tanpa melalui form hasil yang sudah divalidasi.
        $request->validate([
            'tanggal' => 'required|date',
            'disposisi_id' => 'required|string',
        ]);

        $tanggal = $request->tanggal;
        $disposisiId = $request->disposisi_id;

        $query = Agenda::with('disposisi')->whereDate('tanggal', $tanggal);

        if ($disposisiId != 'semua') {
            $query->where('disposisi_id', $disposisiId);
        }

        $agendas = $query->orderBy('jam', 'asc')->get();

        $nama_filter = 'Semua Disposisi';
        if ($disposisiId != 'semua') {
            $disposisiModel = Disposisi::find($disposisiId);
            $nama_filter = $disposisiModel ? $disposisiModel->perihal : 'Tidak Diketahui';
        }

        // Memanggil LaporanExport dengan data yang sudah difilter
        return Excel::download(new LaporanExcel($agendas, $tanggal, $tanggal, $nama_filter), 'Laporan_Agenda.xlsx');
    }
}
