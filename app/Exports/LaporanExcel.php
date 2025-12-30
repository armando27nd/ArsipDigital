<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Carbon\Carbon; // Tambahkan ini
use App\Exports\ExcelBulanSheet; // Tambahkan ini

class LaporanExcel implements WithMultipleSheets
{
    protected $agendas; // Mengubah nama variabel agar konsisten
    protected $tanggalFilter; // Mengubah nama variabel agar konsisten
    protected $disposisiFilter; // Mengubah nama variabel agar konsisten

    public function __construct($agendas, $tanggalFilter, $disposisiFilter)
    {
        $this->agendas = $agendas;
        $this->tanggalFilter = $tanggalFilter;
        $this->disposisiFilter = $disposisiFilter;
    }

    public function sheets(): array
    {
        $sheets = [];

        // Mengatur locale Carbon ke Bahasa Indonesia untuk penamaan sheet
        Carbon::setLocale('id');

        // Jika tidak ada data, buat sheet kosong dengan pesan
        if ($this->agendas->isEmpty()) {
            // Judul sheet untuk kasus tidak ada data
            $noDataTitle = 'Tidak Ada Data';
            if ($this->tanggalFilter) {
                // Pastikan $this->tanggalFilter adalah string tanggal yang valid
                $noDataTitle .= ' ' . Carbon::parse($this->tanggalFilter)->translatedFormat('d F Y');
            }
            // Anda bisa menambahkan filter disposisi ke nama sheet jika diinginkan
            // if ($this->disposisiFilter != 'semua') {
            //     // Perlu ambil nama perihal dari Disposisi model jika ingin menampilkannya
            //     // use App\Disposisi; // Tambahkan di atas
            //     // $disposisiModel = Disposisi::find($this->disposisiFilter);
            //     // $noDataTitle .= ' (' . ($disposisiModel ? $disposisiModel->perihal : 'Tidak Diketahui') . ')';
            // }

            $sheets[] = new ExcelBulanSheet($noDataTitle, collect()); // Mengirim koleksi kosong
            return $sheets;
        }

        // Group agenda berdasarkan tanggal pelaksanaan (d F Y) untuk setiap sheet
        // Pastikan $item->tanggal adalah objek Carbon atau bisa di-parse
        $groupedByDate = $this->agendas->groupBy(function ($item) {
            // Pastikan item->tanggal adalah objek Carbon atau string tanggal yang valid
            return Carbon::parse($item->tanggal)->translatedFormat('d F Y');
        });

        foreach ($groupedByDate as $dateTitle => $items) {
            // Membuat instance ExcelBulanSheet untuk setiap grup tanggal
            // Melewatkan $tanggalFilter dan $disposisiFilter ke ExcelBulanSheet jika diperlukan untuk header
            $sheets[] = new ExcelBulanSheet($dateTitle, $items, $this->tanggalFilter, $this->disposisiFilter);
        }

        return $sheets;
    }
}
