<?php


namespace App\Imports;

use App\Models\Outlet;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OutletImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Outlet([
            'outlet_code' => $row[0],
            'company_name' => $row[1],
            'name' => $row[2],
        ]);
    }
}