<?php

namespace App\Http\Controllers\dth;

use App\Http\Controllers\Controller;
use App\Models\Pendientedth;
use App\Models\dth\PendienteProductodth;
use App\Models\dth\DetallePendienteProductodth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendienteProductodthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('tvdth.pendiente_producto.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tvdth.pendiente_producto.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'users_id' => 'required|exists:users,id',
            'asignaciones' => 'required|array',
            'asignaciones.*.producto_id' => 'required|exists:productodths,id',
            'asignaciones.*.detalle_ids' => 'required|array',
            'asignaciones.*.detalle_ids.*' => 'exists:detalles_productodths,id',
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->asignaciones as $asignacion) {
                // Evitar duplicación de producto asignado
                $pendienteProducto = PendienteProductodth::firstOrCreate([
                    'users_id' => $request->users_id,
                    'producto_id' => $asignacion['producto_id'],
                ]);

                // Evitar duplicación de detalles
                foreach ($asignacion['detalle_ids'] as $detalleId) {
                    DetallePendienteProductodth::firstOrCreate([
                        'pendiente_producto_id' => $pendienteProducto->id,
                        'detalle_producto_id' => $detalleId,
                    ]);
                }
            }

            DB::commit();

            return response()->json(['message' => 'Asignación guardada correctamente'], 200);

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al guardar la asignación',
                'error' => $e->getMessage(),
            ], 500);
        }
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

        public function LoadPendienteProductos()    
    {
        $user = Auth::user();

        // Si el usuario es admin, obtiene todo. Sino, solo lo asignado a él.
        if ($user->hasRole('Admin')) {
            $pendienteProductos = PendienteProductodth::with(['producto', 'users','detalles'])
                ->paginate(10);
        } else {
            $pendienteProductos = PendienteProductodth::with(['producto', 'users','detalles'])
                ->where('users_id', $user->id)
                ->paginate(10);
        }

        $data = $pendienteProductos->map(function ($form) {
            return [
                'id' => $form->id,
                'users_id' => $form->users_id,
                'producto_id' => $form->producto_id,
                'producto_nombre' => $form->producto->producto ?? null,
                'detalles' => $form->detalles->map(function ($detalle) {
                    return [
                        'id' => $detalle->id,
                        'stb' => $detalle->detalleProducto->stb ?? null,
                    ];
                }),
                'asignado_a' => $form->users->name ?? null,
            ];
        });

        return response()->json([
            'data' => $data,
            'current_page' => $pendienteProductos->currentPage(),
            'last_page' => $pendienteProductos->lastPage(),
            'per_page' => $pendienteProductos->perPage(),
            'total' => $pendienteProductos->total(),
        ], 200);
    }

    public function verAsignaciones($id)
    {
        $data = Pendientedth::with([
        'pendienteProductos.producto',
        'pendienteProductos.detalles.detalleProducto'
    ])->findOrFail($id);
        return response()->json($data);
    }

    public function getAsignaciones($id)
    {
        $asignaciones = PendienteProductodth::with(['producto', 'detalles.detalleProducto'])
            ->where('pendiente_id', $id)
            ->get();

        return response()->json($asignaciones);
    }

}
