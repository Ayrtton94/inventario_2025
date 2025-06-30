<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\VentasExport;
use App\Imports\TxtToExcelImport;
use Maatwebsite\Excel\Facades\Excel;

class TxtToExcelController extends Controller
{
    public function index()
    {
        return view('import.index');
    }

    public function convert(Request $request)
    {
        $request->validate(['txt_file' => 'required|file|mimes:txt']);
    
        // Leer el archivo línea por línea
        $lines = file($request->file('txt_file')->getRealPath(), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $data = [];
        $skipNextLine = false; // Para ignorar líneas de "Contrato"
    
        foreach ($lines as $line) {
            // Saltar líneas de metadatos (ej: "Fecha Hora:", "Departamento:")
            if (str_contains($line, ':')) continue;
            
            // Saltar encabezados principales
            if (str_contains($line, 'Ventas Pendientes')) continue;
            
            // Ignorar líneas de "Contrato" (las que vienen después de una fila válida)
            if ($skipNextLine) {
                $skipNextLine = false;
                continue;
            }
    
            // Procesar filas de datos
            $line = trim($line);
            if (!empty($line)) {
                // Dividir por tabs y filtrar columnas vacías
                $columns = array_map('trim', explode("\t", $line));
                $columns = array_values(array_filter($columns, fn($value) => $value !== ''));
                
                // Solo tomar filas que comienzan con "Call Center" u "Oficina"
                if (count($columns) >= 5 && in_array($columns[0], ['Call Center', 'Oficina'])) {
                    $data[] = $columns;
                    $skipNextLine = true; // La siguiente línea es de "Contrato", la ignoramos
                }
            }
        }
    
        // Debug: Verifica los datos antes de generar el Excel
        dd($data);
    
        return Excel::download(
            new TxtToExcelImport($data), // ¡Asegúrate de pasar $data aquí!
            'ventas_pendientes_' . now()->format('Y-m-d') . '.xlsx'
        );
    }

    public function convertirTxtAExcel(Request $request)
{
    $file = $request->file('txt_file');
    $contenido = file($file->getPathname(), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    $datos = [];
    $fila = [];

    foreach ($contenido as $linea) {
        $linea = trim($linea);
        if (str_starts_with($linea, 'Call Center') || str_starts_with($linea, 'Oficina')) {
            if (!empty($fila)) {
                $datos[] = $fila;
            }
            $fila = explode("\t", $linea);
        } else {
            $fila = array_merge($fila, explode("\t", $linea));
        }
    }

    if (!empty($fila)) {
        $datos[] = $fila;
    }

    return Excel::download(new VentasExport($datos), 'ventas_pendientes.xlsx');
}

}
