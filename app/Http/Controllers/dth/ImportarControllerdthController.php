<?php

namespace App\Http\Controllers\dth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\ProductodthImportador;
use App\Imports\PendientedthImportador;
use App\Imports\Detalles_productodthImportador;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ImportarControllerdthController extends Controller
{
    public function index()
    {
        return view('tvdth.importar.index');
    }

    public function importarPendientes(Request $request)
    {
        if (!$request->hasFile('file')) {
            return response()->json(['error' => 'No se envió ningún archivo.'], 400);
        }

        try {
            $userId = Auth::id();
            Excel::import(new PendientedthImportador($userId), $request->file('file'));

            return response()->json(['message' => 'Pendientes importados con éxito']);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al importar pendientes.',
                'detalle' => $e->getMessage()
            ], 500);
        }
    }

    public function importarProductos(Request $request)
    {
        if (!$request->hasFile('file')) {
            return response()->json(['error' => 'No se envió ningún archivo.'], 400);
        }

        try {
            Excel::import(new ProductodthImportador, $request->file('file'));

            return response()->json(['message' => 'Productos importados con éxito']);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al importar productos.',
                'detalle' => $e->getMessage()
            ], 500);
        }
    }

    public function importarDetalleProductos(Request $request)
    {
        if (!$request->hasFile('file')) {
            return response()->json(['error' => 'No se envió ningún archivo.'], 400);
        }

        try {
            Excel::import(new Detalles_productodthImportador, $request->file('file'));

            return response()->json(['message' => 'Detalles importados con éxito']);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al importar detalles.',
                'detalle' => $e->getMessage()
            ], 500);
        }
    }
}
