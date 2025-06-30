<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendientes;
use Illuminate\Support\Facades\Auth;

class AsignadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return view('asignar.index');
    }

    public function asignado()
    {
        $userId = Auth::id(); // Obtener el ID del usuario autenticado

        $pendientes = Pendientes::where('user_id', $userId)->paginate(10); // Puedes ajustar el número de registros por página

        return response()->json([
            'data' => $pendientes->items(),
            'current_page' => $pendientes->currentPage(),
            'last_page' => $pendientes->lastPage(),
            'per_page' => $pendientes->perPage(),
            'total' => $pendientes->total(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
