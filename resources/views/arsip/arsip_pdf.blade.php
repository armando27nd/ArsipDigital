<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class ArsipExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithEvents
{
    protected $arsip;
    protected $jenisSurat;
    protected $bulan;
    protected $tahun;
    protected $rowNumber = 0;

    // 1. Ubah constructor untuk menerima bulan dan tahun dari filter
    public function __construct(Collection $arsip, string $jenisSurat, $bulan, $tahun)
    {
        $this->arsip = $arsip;
        $this->jenisSurat = $jenisSurat;
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->arsip;
    }

    public function headings(): array
    {
        return [
            'NO',
            'KODE KLASIFIKASI',
            'ISI RINGKasan',
            'ASAL/TUJUAN SURAT',
            'NOMOR SURAT',
            'TGL SURAT',
            'UNIT PENGOLAH',
            'KET'
        ];
    }

    public function map($item): array
    {
        $this->rowNumber++;
        return [
            $this->rowNumber,
            $item->kode_klasifikasi,
            $item->isi_ringkasan,
            $item->asal,
            $item->no_surat,
            Carbon::parse($item->tanggal)->format('d-m-Y'),
            $item->unit_pengolah ?? '-',
            $item->keterangan,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            5 => ['font' => ['bold' => true]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $sheet->insertNewRowBefore(1, 4);

                $sheet->mergeCells('A1:H1');
                $sheet->mergeCells('A2:H2');
                $sheet->mergeCells('A3:H3');

                $judul = 'LAPORAN ARSIP';
                if ($this->jenisSurat === 'surat_masuk') {
                    $judul = 'LAPORAN SURAT MASUK';
                } elseif ($this->jenisSurat === 'surat_keluar') {
                    $judul = 'LAPORAN SURAT KELUAR';
                }

                // =================================================================
                // PERUBAHAN UTAMA: Membuat judul berdasarkan filter
                // =================================================================
                Carbon::setLocale('id');

                $bulanTahun = 'PERIODE KESELURUHAN'; // Judul default
                if ($this->bulan && $this->tahun) {
                    // Membuat objek Carbon dari bulan dan tahun yang dipilih
                    $date = Carbon::create()->month($this->bulan)->year($this->tahun);
                    $bulanTahun = 'BULAN ' . strtoupper($date->translatedFormat('F')) . ' TAHUN ' . $this->tahun;
                }

                $sheet->setCellValue('A1', $judul);
                $sheet->setCellValue('A2', $bulanTahun);
                $sheet->setCellValue('A3', 'DINAS TENAGA KERJA KABUPATEN TANGERANG');

                $sheet->getStyle('A1:A3')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
                ]);
            },
        ];
    }
}
