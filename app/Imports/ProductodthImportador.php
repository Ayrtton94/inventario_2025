<?php

namespace App\Imports;

use App\Models\dth\Productodth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductodthImportador implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if (isset($row['cod_producto']) && $row['cod_producto'] !== null) {
                Productodth::updateOrCreate(
                    ['cod_producto' => $row['cod_producto']], 
                    [
                        'producto' => $row['producto'],
                        'cantidad' => $row['cantidad']
                    ]
                );
            }
        }
    }
}
