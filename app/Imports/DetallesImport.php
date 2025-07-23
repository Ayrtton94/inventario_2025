<?php

namespace App\Imports;

use App\Models\Detalles_producto;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class DetallesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $codArt = isset($row['cod_art']) ? trim($row['cod_art']) : null;
        $fechaIngreso = $this->convertirFecha($row['fecha_ingreso'] ?? null);

        if ($codArt) {
            $producto = Product::where('cod_producto', $codArt)->first();

            if (!$producto) {
                Log::warning("Producto con cod_art '{$codArt}' no encontrado.");
                return null;
            }

            return new Detalles_producto([
                'fecha_ingreso' => $fechaIngreso,
                'stb' => $row['stb'] ?? '',
                'cod_art' => $codArt,
                'estado' => $row['estado'] ?? 'Desconocido',
                'producto_id' => $producto->id,
            ]);
        }

        Log::warning("Fila ignorada porque 'cod_art' es null o vacío.", $row);
        return null;
    }

    private function convertirFecha($fecha)
    {
        // Si es una fecha de Excel en formato numérico (número de días desde 1900)
        if (is_numeric($fecha)) {
            return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($fecha))->format('Y-m-d');
        }

        // Si ya es una fecha válida tipo texto
        try {
            return Carbon::parse($fecha)->format('Y-m-d');
        } catch (\Exception $e) {
            Log::error("Error al convertir fecha: '{$fecha}'", ['error' => $e->getMessage()]);
            return null;
        }
    }
}
