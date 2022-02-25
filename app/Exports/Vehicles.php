<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class Vehicles implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public $rows;

    public function __construct($rows)
    {
        $this->rows = $rows;
    }

    public function headings(): array
    {
        return [
            'Model',
            'Type',
            'Year'
        ];
    }

    public function map($row): array
    {
        return [
            $row->model,
            $row->type,
            $row->year
        ];
    }

    public function collection()
    {
        return $this->rows;
    }
}
