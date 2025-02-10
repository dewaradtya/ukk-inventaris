<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class InventoryExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithMapping
{
    protected $inventorys;

    public function __construct($inventorys)
    {
        $this->inventorys = $inventorys;
    }

    public function collection()
    {
        return $this->inventorys;
    }

    public function headings(): array
    {
        return [
            "Name",
            "Condition",
            "Amount",
            "Register Date",
            "Code",
            "Type",
            "Room",
            "User"
        ];
    }

    public function map($inventory): array
    {
        return [
            $inventory->name,
            $inventory->condition,
            $inventory->amount,
            $inventory->register_date,
            $inventory->code,
            $inventory->type->name ?? 'N/A',
            $inventory->room->name ?? 'N/A',
            $inventory->user->name ?? 'N/A',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();
        $lastColumn = $sheet->getHighestColumn();

        $sheet->setTitle('Inventaris');

        return [
            1 => [
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
            ],
            'A2:' . $lastColumn . $lastRow => [
                'alignment' => [
                    'horizontal' => 'center',
                    'vertical' => 'center',
                ],
                'font' => [
                    'size' => 11,
                ],
            ],
            'A1:' . $lastColumn . $lastRow => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'CCCCCC'],
                    ],
                    'outline' => [
                        'borderStyle' => Border::BORDER_MEDIUM,
                        'color' => ['rgb' => '4472C4'],
                    ],
                ],
            ],
        ];
    }
}
