<?php

namespace App\Imports;

use App\Models\Detalles_producto;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class DetallesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
    // Normalizamos nombres de columnas
    $codArt = isset($row['cod_art']) ? trim($row['cod_art']) : null;

    if ($codArt) {
        $producto = Product::where('cod_producto', $codArt)->first();

        if (!$producto) {
            \Log::warning("Producto con cod_art '{$codArt}' no encontrado.");
            return null; // Ignorar fila si no se encuentra el producto
        }

        return new Detalles_producto([
            'fecha_ingreso' => $row['fecha_ingreso'] ?? now(),
            'stb' => $row['stb'] ?? '',
            'cod_art' => $codArt,
            'estado' => $row['estado'] ?? 'Desconocido',
            'producto_id' => $producto->id,
        ]);
    }

    // Si cod_art está vacío, no devuelve nada
    \Log::warning("Fila ignorada porque 'cod_art' es null o vacío.", $row);
    return null;
}
}
