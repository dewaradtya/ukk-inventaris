<?php

namespace App\Exports;

use App\Models\Room;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class RoomExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Room::select("id", "name", "code", "information")->get();
    }
    
    /**
     * Add table headings.
     *
     * @return array
     */
    public function headings(): array
    {
        return ["ID", "Name", "Code", "Information"];
    }

    /**
     * Set title for the sheet.
     *
     * @return string
     */
    public function title(): string
    {
        return 'Ruang Inventaris';
    }

    /**
     * Apply styles to the worksheet.
     *
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();
        
        $lastColumn = $sheet->getHighestColumn();
        
        $sheet->setTitle('Ruang Inventaris');
        
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

    /**
     * @param Worksheet $sheet
     * @return void
     */
    public function beforeExport(Worksheet $sheet)
    {
        $sheet->getDefaultRowDimension()->setRowHeight(20);
        
        $sheet->freezePane('A2');
    }
}