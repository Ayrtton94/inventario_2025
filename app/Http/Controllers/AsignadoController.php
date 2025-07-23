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

    public function asignados()
    {
       $user = Auth::user();
        // Si el usuario es admin, obtiene todos los registros
        if ($user->hasRole('Admin')) {
            $pendientes = Pendientes::with('user')->paginate(10);
        } else {
            // Usuarios normales solo ven sus asignados
            $pendientes = Pendientes::where('user_id', $user->id)->paginate(10);
        }

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
