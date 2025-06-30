<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\TxtToExcelImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class ExcelController extends Controller
{
    public function __construct()
{
    $this->middleware('can:importexcel.index')->only('index');
}
    public function index()
    {
        return view('import.index');
    }

    public function import(Request $request)
    {
        if (!$request->hasFile('file')) {
            return response()->json(['error' => 'No se envió ningún archivo.'], 400);
        }

        try {
            $userId = Auth::id(); // o el ID del técnico si lo quieres asignar manualmente
            Excel::import(new TxtToExcelImport($userId), $request->file('file'));

            return response()->json(['message' => 'Pendientes importados con éxito']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al importar: ' . $e->getMessage()], 500);
        }
    }
}
