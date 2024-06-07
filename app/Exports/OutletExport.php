<?php

namespace App\Exports;

use App\Models\Outlet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OutletExport implements FromCollection, WithHeadings
{
    protected $records;

    public function __construct(array $records)
    {
        $this->records = $records;
    }

    public function collection()
    {
        return Outlet::whereIn('id', $this->records)->get();
    }

    public function headings(): array
    {
        return [
            'Code Outlet',
            'Nama PT',
            'Nama Outlet',
        ];
    }
}