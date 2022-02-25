<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class Energy implements FromCollection, WithHeadings, WithMapping
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
            'Country',
            'Company'
        ];
    }

    public function map($row): array
    {
        return [
            $row->country,
            $row->company
        ];
    }

    public function collection()
    {
        return $this->rows;
    }
}
