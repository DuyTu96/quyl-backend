<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class Filters implements FromCollection, WithHeadings, WithMapping
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
            'Filter Name',
            'Filter Type'
        ];
    }

    public function map($row): array
    {
        return [
            $row->filter_name,
            $row->filter_type
        ];
    }

    public function collection()
    {
        return $this->rows;
    }
}
