<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (isset($row['cod_producto']) && $row['cod_producto'] !== null) {
            Product::create([
                'cod_producto' => $row['cod_producto'],
                'producto' => $row['producto'],
                'cantidad' => $row['cantidad'],
            ]);
        }
    }
}
