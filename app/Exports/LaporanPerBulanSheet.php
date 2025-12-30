<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Carbon;

class LaporanPerBulanSheet implements WithTitle, WithEvents
{
    protected $month;
    protected $items;
    protected $dari;
    protected $sampai;

    // Custom column widths
    protected $columnWidths = [
        'A' => 4.14,   // NO
        'B' => 11.86,  // JAM
        'C' => 30,  // KEGIATAN
        'D' => 21.29,  // TEMPAT
        'E' => 20.71,  // PEJABAT
        'F' => 8.86   // KETERANGAN
    ];

    // Custom row heights
    protected $rowHeights = [
        'header1' => 18,
        'header2' => 23.25,
        'header3' => 14.25,
        'header4' => 14.25,
        'header6' => 14.25,
        'header5' => 14.25,
        'info' => 20,
        'column_header' => 31.5,
        'data_row' => 52
    ];

    public function __construct($month, $items, $dari = null, $sampai = null)
    {
        $this->month = $month;
        $this->items = $items;
        $this->dari = $dari;
        $this->sampai = $sampai;
    }

    public function title(): string
    {
        return $this->month;
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

                // Additional styling
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
    $sheet->mergeCells("A1:F1")->setCellValue("A1", "PEMERINTAH KABUPATEN TANGERANG");
    $sheet->mergeCells("A2:F2")->setCellValue("A2", "DINAS TENAGA KERJA");
    $sheet->mergeCells("A3:F3")->setCellValue("A3", "Jalan Raya Parahu RT/RW. 05/01, Desa Parahu, Kecamatan Sukamulya, Kab Tangerang, Banten");
    $sheet->mergeCells("A4:F4")->setCellValue("A4", "Kode Pos, 15612 Telepon 021-59433197, Laman : disnaker@tangerangkab.go.id");
    $sheet->mergeCells("A5:F5")->setCellValue("A5","");
    $sheet->mergeCells("A6:F6")->setCellValue("A6","");


    // Styling (sesuaikan jika perlu)
    $sheet->getStyle("A1")->getFont()->setSize(14);
    $sheet->getStyle("A2")->getFont()->setSize(18)->setBold(true);
    $sheet->getStyle("A3:A6")->getFont()->setSize(10);
    
    // Set alignment center untuk semua header
    $sheet->getStyle("A1:F4")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    // Garis pemisah
    $sheet->getStyle("A6:F6")->getBorders()->getTop()->setBorderStyle(Border::BORDER_MEDIUM);
}

    protected function addDateInfo($sheet)
{
    // Set row heights
    $sheet->getRowDimension(8)->setRowHeight($this->rowHeights['info']);
    $sheet->getRowDimension(9)->setRowHeight($this->rowHeights['info']);

    // Date information - Menggunakan pendekatan row-based
    $sheet->setCellValueByColumnAndRow(1, 8, "JADWAL HARIAN   :   DINAS TENAGA KERJA KAB. TANGERANG");
    // $sheet->mergeCellsByColumnAndRow(1, 6, 6, 6); // Merge dari kolom 1 (A) sampai 6 (F) di baris 6

    $sheet->setCellValueByColumnAndRow(1, 9, "HARI/TANGGAL      :   " . now()->translatedFormat('l, d F Y'));
    // $sheet->mergeCellsByColumnAndRow(1, 7, 6, 7); // Merge dari kolom 1 (A) sampai 6 (F) di baris 7

    // Apply styling ke range yang benar
    $sheet->getStyleByColumnAndRow(1, 8, 1, 9)->applyFromArray([
        'font' => ['Arial', 'size' => 12, 'bold' => true]]);
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
            ->setOddHeader('&C&H' . $this->month)
            ->setOddFooter('&L&D &RPage &P of &N');

        // Margins
        $sheet->getPageMargins()
            ->setTop(0.5)
            ->setRight(0.5)
            ->setLeft(0.5)
            ->setBottom(0.5);
    }
}