<?php
namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class DataImport implements ToCollection
{
    private $excel_rows = array();

    public function collection(Collection $collection)
    {
        foreach ($collection->chunk(100) as $chunk) {
            foreach ($chunk as $row) {
                $this->excel_rows[] = $row;
            }
        }
    }

    public function getExcelRows()
    {
        return $this->excel_rows;
    }
}
