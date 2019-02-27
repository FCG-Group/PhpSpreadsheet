<?php

namespace PhpOffice\PhpSpreadsheetTests\Reader;

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PHPUnit\Framework\TestCase;

class XlsxTest extends TestCase
{
    /**
     * Test load Xlsx file without cell reference.
     */
    public function testLoadXlsxWithoutCellReference()
    {
        $filename = './data/Reader/XLSX/without_cell_reference.xlsx';
        $reader = new Xlsx();

        $reader->setLazyInitCells(false);
        $spreadsheet = $reader->load($filename);
        $firstSheet = $spreadsheet->getSheet(0);
        self::assertEquals('2', $firstSheet->getCell('B2')->getValue());

        $reader->setLazyInitCells(true);
        $spreadsheet = $reader->load($filename);
        $firstSheet = $spreadsheet->getSheet(0);
        self::assertEquals('2', $firstSheet->getCell('B2')->getValue());
    }

    /**
     * Test load Xlsx file and use a read filter.
     */
    public function testLoadWithReadFilter()
    {
        $filename = './data/Reader/XLSX/without_cell_reference.xlsx';
        $reader = new Xlsx();
        $reader->setReadFilter(new OddColumnReadFilter());
        $data = $reader->load($filename)->getActiveSheet()->toArray();
        $ref = [1.0, null, 3.0, null, 5.0, null, 7.0, null, 9.0, null];

        for ($i = 0; $i < 10; ++$i) {
            $this->assertEquals($ref, \array_slice($data[$i], 0, 10, true));
        }
    }
}
