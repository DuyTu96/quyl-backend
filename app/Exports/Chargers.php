<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class Chargers implements FromCollection, WithHeadings, WithMapping
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
            'Charger ID',
            'Location',
            'Usage Type',
            'Connector Type',
            'Operator',
            'Contact Telephone',
            'Cost',
            'Service Time',
        ];
    }

    public function map($row): array
    {
        return [
            $row->charger_id,
            $row->location,
            $row->usage_type,
            $row->connector_type,
            $row->operator,
            $row->contact_telephone,
            $row->cost,
            $row->service_time,
        ];
    }

    public function collection()
    {
        return $this->rows;
    }
}
