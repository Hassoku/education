<?php
/**
 * Created by PhpStorm.
 * User: Furqan Talpur
 * Date: 7/24/2018
 * Time: 3:29 PM
 */

namespace App\Http\Controllers\Web\Admin\excelExports;


use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Sheet;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class BalanceReport implements FromCollection, WithTitle, WithHeadings, WithEvents, ShouldAutoSize// auto adjust the size
{
    use Exportable, RegistersEventListeners;

    private $data;
    private $sheetTitle;
    private $headings;
    public function __construct($data, $sheetTitle, $headings){
        $this->data = $data;
        $this->sheetTitle = $sheetTitle;
        $this->headings = $headings;

        // macro for cell styling
        Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
            $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
        });

        // macro for merge cells
        Sheet::macro('mergeCells', function (Sheet $sheet, string $cellRange) {
            $sheet->getDelegate()->mergeCells($cellRange);
        });
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->sheetTitle;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return $this->headings;

    }

    //// events
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => [self::class , 'afterSheet'],
        ];
    }

    public static function beforeExport(BeforeExport $event)
    {
        //
    }

    public static function beforeWriting(BeforeWriting $event)
    {
        //
    }

    public static function beforeSheet(BeforeSheet $event)
    {
        //
    }

    public static function afterSheet(AfterSheet $event)
    {
        $countCols = 0;
        $lastCol = 'A';
        $totalRows = 0;
        foreach($event->sheet->getDelegate()->getRowIterator() as $row){
            // can Iterate the each cell
            if($totalRows < 1){
                // count the number of columns of first row
                foreach ($row->getCellIterator() as $cell){
                    if($countCols > 0){
                        $lastCol++;
                    }
                    $countCols++;
                }
            }
            $totalRows++;
        }

        // using macro styleCells
        $event->sheet->styleCells(
            'A1:'.$lastCol.'1',
            [
                'font' => [
                    'bold' => true
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ],
                'fill' => [
                    'fillType' => Fill::FILL_GRADIENT_LINEAR,
                    'rotation' => 90,
                    'startColor' => [
                        'argb' => 'FFA0A0A0',
                    ],
                    'endColor' => [
                        'argb' => 'FFFFFFFF',
                    ],
                ],
            ]
        );

        // style the whole sheet
        $event->sheet->styleCells(
            'A1:'.$lastCol.$totalRows,
            [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ]
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
//                    'vertical' => Alignment::VERTICAL_CENTER
                ]
            ]
        );

        // style the last row [total row]
        $event->sheet->styleCells(
            'A'.$totalRows.':'.$lastCol.$totalRows,
            [
                'font' => [
                    'bold' => true
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
//                    'vertical' => Alignment::VERTICAL_CENTER
                ],
                'fill' => [
                    'fillType' => Fill::FILL_GRADIENT_LINEAR,
                    'rotation' => 90,
                    'startColor' => [
                        'argb' => 'FFA0A0A0',
                    ],
                    'endColor' => [
                        'argb' => 'FFFFFFFF',
                    ],
                ],

            ]
        );
    }
}