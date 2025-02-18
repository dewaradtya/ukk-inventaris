<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReturnExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $returns;

    public function __construct($returns)
    {
        $this->returns = $returns;
    }

    public function collection()
    {
        return $this->returns;
    }

    public function headings(): array
    {
        return [
            "Tanggal Peminjaman",
            "Tanggal Pengembalian",
            "Tanggal Dikembalikan",
            "Status",
            "Pegawai",
            "Inventaris Dipinjam",
        ];
    }

    public function map($return): array
    {
        $inventories = $return->loanDetails->map(function ($loanDetail) {
            return optional($loanDetail->inventory)->name . ' (' . $loanDetail->amount . ')';
        })->implode(', ');

        return [
            $return->borrow_date,
            $return->return_date ?? '-',
            $return->actual_return_date,
            ucfirst($return->loan_status),
            optional($return->employee)->name ?? 'N/A',
            $inventories,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();
        $lastColumn = $sheet->getHighestColumn();

        $sheet->setTitle('Return');

        $sheet->getStyle('A1:' . $lastColumn . '1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4472C4'],
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
            ],
        ]);

        $sheet->getStyle('A2:' . $lastColumn . $lastRow)->applyFromArray([
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],
            'font' => [
                'size' => 11,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'CCCCCC'],
                ],
            ],
        ]);
    }
}
