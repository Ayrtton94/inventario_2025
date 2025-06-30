<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DetallesImport;
use App\Imports\ProductsImport;

class ImportarController extends Controller
{    

    public function importarProductos(Request $request)
    {
        if (!$request->hasFile('file')) {
            return response()->json(['error' => 'No se envió ningún archivo.'], 400);
        }

        try {
            Excel::import(new ProductsImport, $request->file('file'));

            return response()->json(['message' => 'Productos importados con éxito']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al importar: ' . $e->getMessage()], 500);
        }
    }

    public function importarDetalleProductos(Request $request)
    {
        if (!$request->hasFile('file')) {
            return response()->json(['error' => 'No se envió ningún archivo.'], 400);
        }

        try {
            Excel::import(new DetallesImport, $request->file('file'));

            return response()->json(['message' => 'Productos importados con éxito']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al importar: ' . $e->getMessage()], 500);
        }
    }
}
