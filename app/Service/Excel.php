<?php

namespace App\Service;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class Excel
{
    public static function generateExcel($titles = [], $values = [])
    {
        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $columnArray = [];
        foreach ($titles as $key => $title) {
            $column = self::columnNameFromIndex($key);
            $columnArray[] = $column;
            $sheet->setCellValue($column.'1', $title);
        }
        $firstColumn = $columnArray[0];
        $lastColumn = end($columnArray);
        $sheet->getStyle($firstColumn.'1:'.$lastColumn.'1')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('9BCF41');
        $sheet->getStyle($firstColumn.'1:'.$lastColumn.'1')->getFont()->setBold(true);
        $sheet->getStyle($firstColumn.':'.$lastColumn)->getAlignment()->setVertical('center')->setWrapText(true);
        foreach ($titles as $key => $title) {
            $column = self::columnNameFromIndex($key);
            if ($title == 'Avatar') {
                $sheet->getColumnDimension($column)->setWidth(20);
            } else {
                $sheet->getColumnDimension($column)->setAutoSize(true);
            }
        }
        foreach ($titles as $index => $title) {
            $column = self::columnNameFromIndex($index);
            $key = 2;
            if (isset($values[$title])) {
                foreach ($values[$title] as $value) {
                    if ($title == 'Avatar') {
                        $sheet->getRowDimension($key)->setRowHeight(80);
                        $drawing = new Drawing();
                        $drawing->setName('Paid');
                        $drawing->setDescription('Paid');
                        $drawing->setPath($value);
                        $drawing->setCoordinates($column.$key);
                        $drawing->setWidth(100);
                        $drawing->setWorksheet($spreadsheet->getActiveSheet());
                    } else {
                        $sheet->setCellValue($column.$key, $value);
                    }
                    $key++;
                }
            }
        }
        $writer = new Xlsx($spreadsheet);
        header('Access-Control-Allow-Origin: *');
        $writer->save('php://output');
    }
    public static function columnNameFromIndex($number)
    {
        if ($number === 0) {
            return "A";
        }
        $name='';
        while ($number  >0) {
            $name = chr(65 + $number % 26).$name;
            $number = intval($number / 26) - 1;
            if ($number === 0) {
                $name="A".$name;
                break;
            }
        }
        return $name;
    }
    public static function generateClassExcel($result)
    {
        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();
        $activeWorksheet->setCellValue('A1', 'Class');
        $activeWorksheet->setCellValue('B1', 'Name');
        $activeWorksheet->getStyle('A1:B1')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('9BCF41');
        $activeWorksheet->getStyle('A1:B1')->getFont()->setBold(true);
        $activeWorksheet->getStyle('A1:B1')->getAlignment()->setVertical('center')->setWrapText(true);
        $activeWorksheet->getColumnDimension('A')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('B')->setAutoSize(true);
        $key = 2;
        foreach ($result as $data) {
            if (count($data['section']) > 0) {
                $key1 = $key + count($data['section']) - 1;
            } else {
                $key1 = $key;
            }
            $activeWorksheet->mergeCells('A'.$key.':'.'A'.$key1);
            $activeWorksheet->setCellValue('A'.$key, $data['name']);
            $index = $key;
            foreach ($data['section'] as $section) {
                $activeWorksheet->setCellValue('B'.$index, $section['name']);
                $index++;
            }
            $key = $key1;
            $key++;
        }
        $writer = new Xlsx($spreadsheet);
        header('Access-Control-Allow-Origin: *');
        $writer->save('php://output');
    }
    public static function generateClassSubjectExcel($result)
    {
        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();
        $activeWorksheet->setCellValue('A1', 'Class');
        $activeWorksheet->setCellValue('B1', 'Subject');
        $activeWorksheet->getStyle('A1:B1')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('9BCF41');
        $activeWorksheet->getStyle('A1:B1')->getFont()->setBold(true);
        $activeWorksheet->getStyle('A1:B1')->getAlignment()->setVertical('center')->setWrapText(true);
        $activeWorksheet->getColumnDimension('A')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('B')->setAutoSize(true);
        $key = 2;
        foreach ($result as $data) {
            if (count($data['subject']) > 0) {
                $key1 = $key + count($data['subject']) - 1;
            } else {
                $key1 = $key;
            }
            $activeWorksheet->mergeCells('A'.$key.':'.'A'.$key1);
            $activeWorksheet->setCellValue('A'.$key, $data['name']);
            $index = $key;
            foreach ($data['subject'] as $subject) {
                $activeWorksheet->setCellValue('B'.$index, $subject['name']);
                $index++;
            }
            $key = $key1;
            $key++;
        }
        $writer = new Xlsx($spreadsheet);
        header('Access-Control-Allow-Origin: *');
        $writer->save('php://output');
    }
    public static function generateClassFeeExcel($result)
    {
        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();
        $activeWorksheet->setCellValue('A1', 'Class');
        $activeWorksheet->setCellValue('B1', 'Fee Type');
        $activeWorksheet->setCellValue('C1', 'Amount');
        $activeWorksheet->getStyle('A1:C1')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('9BCF41');
        $activeWorksheet->getStyle('A1:C1')->getFont()->setBold(true);
        $activeWorksheet->getStyle('A1:C1')->getAlignment()->setVertical('center')->setWrapText(true);
        $activeWorksheet->getColumnDimension('A')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('B')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('C')->setAutoSize(true);
        $key = 2;
        foreach ($result as $data) {
            if (count($data['fees']) > 0) {
                $key1 = $key + count($data['fees']) - 1;
            } else {
                $key1 = $key;
            }
            $activeWorksheet->mergeCells('A'.$key.':'.'A'.$key1);
            $activeWorksheet->setCellValue('A'.$key, $data['name']);
            $index = $key;
            foreach ($data['fees'] as $fee) {
                $activeWorksheet->setCellValue('B'.$index, $fee['name']);
                $activeWorksheet->setCellValue('B'.$index, $fee['amount']);
                $index++;
            }
            $key = $key1;
            $key++;
        }
        $writer = new Xlsx($spreadsheet);
        header('Access-Control-Allow-Origin: *');
        $writer->save('php://output');
    }
}
