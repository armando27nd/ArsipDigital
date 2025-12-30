<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\FromCollection; // Tambahkan ini
use Maatwebsite\Excel\Concerns\WithHeadings; // Tambahkan ini
use Maatwebsite\Excel\Concerns\WithMapping; // Tambahkan ini

use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Events\AfterSheet;
use Carbon\Carbon; // Pastikan Carbon di-import

class ExcelBulanSheet implements WithTitle, WithEvents, FromCollection, WithHeadings, WithMapping // Tambahkan FromCollection, WithHeadings, WithMapping
{
    protected $title; // Mengubah nama properti dari $month menjadi $title
    protected $items;
    protected $tanggalFilter; // Tanggal filter dari controller
    protected $disposisiFilter; // Disposisi filter dari controller

    // Custom column widths
    protected $columnWidths = [
        'A' => 4.14,   // NO
        'B' => 11.86,  // JAM
        'C' => 20,     // TANGGAL PELAKSANAAN (baru)
        'D' => 30,     // KEGIATAN
        'E' => 21.29,  // TEMPAT
        'F' => 20.71,  // PEJABAT YANG HADIR
    ];

    // Custom row heights
    protected $rowHeights = [
        'header1' => 18,
        'header2' => 23.25,
        'header3' => 14.25,
        'header4' => 14.25,
        'header5' => 14.25,
        'header6' => 14.25,
        'info' => 20,
        'column_header' => 31.5,
        'data_row' => 52
    ];

    public function __construct($title, $items, $tanggalFilter = null, $disposisiFilter = null)
    {
        $this->title = $title;
        $this->items = $items;
        $this->tanggalFilter = $tanggalFilter;
        $this->disposisiFilter = $disposisiFilter;
    }

    public function collection()
    {
        return $this->items;
    }

    public function headings(): array
    {
        // Header kolom untuk Excel, harus sesuai dengan urutan di map()
        return [
            'No',
            'Jam',
            'Kegiatan',
            'Tempat',
            'Pejabat Yang Hadir',
            'Keterangan',
            ];
    }

    /**
     * @param mixed $item Agenda model instance
     */
    public function map($item): array
    {
        // Mengatur locale Carbon ke Bahasa Indonesia untuk nama bulan
        Carbon::setLocale('id');

        return [
            '', // Kolom No akan diisi di AfterSheet event
            Carbon::parse($item->jam)->format('H.i') . ' WIB', // Format jam: 07.30 WIB
            Carbon::parse($item->tanggal)->translatedFormat('d F Y'), // Format tanggal: 08 Juli 2025
            $item->kegiatan,
            $item->tempat,
            $item->pejabat,
            // $item->keterangan,
            // $item->disposisi->no_dan_tanggal ?? 'N/A', // Menggunakan relasi
        ];
    }

    public function title(): string
    {
        return $this->title;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Set default font
                $sheet->getParent()->getDefaultStyle()->getFont()->setName('Arial');

                // Add logo if exists
                if (file_exists(public_path('logo.png'))) {
                    $drawing = new Drawing();
                    $drawing->setName('Logo');
                    $drawing->setDescription('Logo Pemkab');
                    $drawing->setPath(public_path('logo.png'));
                    $drawing->setHeight(70);
                    $drawing->setCoordinates('A1');
                    $drawing->setWorksheet($sheet);
                }

                // Set page layout
                $sheet->getPageSetup()
                    ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE)
                    ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4)
                    ->setFitToWidth(1);

                // Header section
                $this->addHeader($sheet);

                // Date information
                $this->addDateInfo($sheet);

                // Data table
                $this->addDataTable($sheet);

                // Apply final styling
                $this->applyFinalStyling($sheet);
            },
        ];
    }

    protected function addHeader($sheet)
    {
        // Atur tinggi masing-masing baris header
        $sheet->getRowDimension(1)->setRowHeight($this->rowHeights['header1']);
        $sheet->getRowDimension(2)->setRowHeight($this->rowHeights['header2']);
        $sheet->getRowDimension(3)->setRowHeight($this->rowHeights['header3']);
        $sheet->getRowDimension(4)->setRowHeight($this->rowHeights['header4']);
        $sheet->getRowDimension(5)->setRowHeight($this->rowHeights['header5']);
        $sheet->getRowDimension(6)->setRowHeight($this->rowHeights['header6']);


        // Merge cells dan isi konten
        $sheet->mergeCells("A1:F1")->setCellValue("A1", "PEMERINTAH KABUPATEN TANGERANG"); // Sesuaikan range merge
        $sheet->mergeCells("A2:F2")->setCellValue("A2", "DINAS TENAGA KERJA"); // Sesuaikan range merge
        $sheet->mergeCells("A3:F3")->setCellValue("A3", "Jalan Raya Parahu RT/RW. 05/01, Desa Parahu, Kecamatan Sukamulya, Kab Tangerang, Banten"); // Sesuaikan range merge
        $sheet->mergeCells("A4:F4")->setCellValue("A4", "Kode Pos, 15612 Telepon 021-59433197, Laman : disnaker@tangerangkab.go.id"); // Sesuaikan range merge
        $sheet->mergeCells("A5:F5")->setCellValue("A5",""); // Sesuaikan range merge
        $sheet->mergeCells("A6:F6")->setCellValue("A6",""); // Sesuaikan range merge


        // Styling (sesuaikan jika perlu)
        $sheet->getStyle("A1")->getFont()->setSize(14);
        $sheet->getStyle("A2")->getFont()->setSize(18)->setBold(true);
        $sheet->getStyle("A3:A6")->getFont()->setSize(10);

        // Set alignment center untuk semua header
        $sheet->getStyle("A1:F4")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Sesuaikan range

        // Garis pemisah
        // Ini akan membuat border bawah pada sel A6:H6
        $sheet->getStyle("A6:F6")->getBorders()->getTop()->setBorderStyle(Border::BORDER_MEDIUM);
        // Untuk compound type "Thin Thick" Anda perlu custom border atau menggunakan template.
        // PHPSpreadsheet tidak memiliki compound type secara langsung seperti di Excel UI.
        // Anda bisa mencoba mengatur 2 border berbeda di baris yang sama atau menggunakan 2 baris.
        // Contoh untuk Thin Thick (pendekatan 2 baris, atau 2 border pada satu baris jika memungkinkan)
        // Ini adalah workaround, bukan compound type native
        // $sheet->getStyle("A6:H6")->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THICK); // Garis tebal
        // $sheet->getStyle("A5:H5")->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN); // Garis tipis di atasnya
    }

    protected function addDateInfo($sheet)
    {
        // Set row heights
        $sheet->getRowDimension(8)->setRowHeight($this->rowHeights['info']);
        $sheet->getRowDimension(9)->setRowHeight($this->rowHeights['info']);

        // Date information - Menggunakan pendekatan row-based
        $sheet->setCellValue("A8", "JADWAL HARIAN   :   DINAS TENAGA KERJA KAB. TANGERANG");
        $sheet->mergeCells("A8:D8"); // Merge dari kolom A sampai H

        // Menggunakan tanggal filter yang sebenarnya, bukan tanggal saat ini
        Carbon::setLocale('id'); // Pastikan locale diatur di sini juga
        $displayDate = $this->tanggalFilter ? Carbon::parse($this->tanggalFilter)->translatedFormat('l, d F Y') : 'Tanggal Tidak Tersedia';
        $sheet->setCellValue("A9", "HARI/TANGGAL      :   " . $displayDate);
        $sheet->mergeCells("A9:D9"); // Merge dari kolom A sampai H

        // Apply styling ke range yang benar
        $sheet->getStyle("A8:D9")->applyFromArray([ // Sesuaikan range
            'font' => ['name' => 'Arial', 'size' => 12, 'bold' => true],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
        ]);
    }

     protected function addDataTable($sheet)
    {
        // Column headers
        $headers = ['NO', 'JAM', 'KEGIATAN', 'TEMPAT', 'PEJABAT YANG HADIR', 'KET.'];
        $startRow = 11;

        // Set column header row height
        $sheet->getRowDimension($startRow)->setRowHeight($this->rowHeights['column_header']);

        // Apply column widths
        foreach ($this->columnWidths as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        // Write headers
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue("{$col}{$startRow}", $header);
            $sheet->getStyle("{$col}{$startRow}")->applyFromArray([
                'font' => ['size' => 11, 'bold' => true],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
            ]);
            $col++;
        }

        // Data rows
        $row = $startRow + 1;
        $no = 1;
        foreach ($this->items as $item) {
            $sheet->getRowDimension($row)->setRowHeight($this->rowHeights['data_row']);

            $sheet->setCellValue("A{$row}", $no++);
            $sheet->setCellValue("B{$row}", $item->jam ?? '-');
            $sheet->setCellValue("C{$row}", $item->kegiatan . "\n(" . ($item->nama_surat ?? '-') . ")");
            $sheet->setCellValue("D{$row}", $item->tempat ?? '-');
            $sheet->setCellValue("E{$row}", $item->pejabat ?? '-');
            $sheet->setCellValue("F{$row}", $item->keterangan ?? '-');

            $sheet->getStyle("A{$row}:F{$row}")->applyFromArray([
                'font' => ['size' => 11],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true
                ],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
            ]);

            $row++;
        }

        // Enable text wrapping for activities column
        $sheet->getStyle("C10:C" . ($row - 1))->getAlignment()->setWrapText(true);
    }

    protected function applyFinalStyling($sheet)
    {


        // Set print area
        $sheet->getPageSetup()->setPrintArea('A1:F' . $sheet->getHighestRow());

        // Header/footer
        $sheet->getHeaderFooter()
            ->setOddHeader('&C&H' . $this->title)
            ->setOddFooter('&L&D &RPage &P of &N');

        // Margins
        $sheet->getPageMargins()
            ->setTop(0.5)
            ->setRight(0.5)
            ->setLeft(0.5)
            ->setBottom(0.5);
    }
}
