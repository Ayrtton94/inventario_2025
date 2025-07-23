<?php

namespace App\Http\Controllers;

use App\Models\Pendientes;
use Illuminate\Http\Request;
use App\Models\PendienteProducto;
use Illuminate\Support\Facades\DB;
use App\Models\DetallePendienteProducto;
use Illuminate\Support\Facades\Auth;

class PendienteProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view ('asignar_producto.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('asignar_producto.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   /* public function store(Request $request)
   {
        $request->validate([
            'pendiente_id' => 'required|exists:pendientes,id',
            'asignaciones' => 'required|array',
            'asignaciones.*.producto_id' => 'required|exists:products,id',
            'asignaciones.*.detalle_ids' => 'required|array',
            'asignaciones.*.detalle_ids.*' => 'exists:detalles_productos,id',
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->asignaciones as $asignacion) {
                // Guardar relación Pendiente ↔ Producto
                $pendienteProducto = PendienteProducto::create([
                    'pendiente_id' => $request->pendiente_id,
                    'producto_id' => $asignacion['producto_id'],
                ]);

                // Guardar relación Detalles ↔ PendienteProducto
                foreach ($asignacion['detalle_ids'] as $detalleId) {
                    DetallePendienteProducto::create([
                        'pendiente_producto_id' => $pendienteProducto->id,
                        'detalle_producto_id' => $detalleId,
                    ]);
                }
            }

            DB::commit();

            return response()->json(['message' => 'Asignación guardada correctamente'], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al guardar la asignación',
                'error' => $e->getMessage(),
            ], 500);
        }
    }*/

        public function store(Request $request)
    {
        $request->validate([
            'users_id' => 'required|exists:users,id',
            'asignaciones' => 'required|array',
            'asignaciones.*.producto_id' => 'required|exists:products,id',
            'asignaciones.*.detalle_ids' => 'required|array',
            'asignaciones.*.detalle_ids.*' => 'exists:detalles_productos,id',
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->asignaciones as $asignacion) {
                // Evitar duplicación de producto asignado
                $pendienteProducto = PendienteProducto::firstOrCreate([
                    'users_id' => $request->users_id,
                    'producto_id' => $asignacion['producto_id'],
                ]);

                // Evitar duplicación de detalles
                foreach ($asignacion['detalle_ids'] as $detalleId) {
                    DetallePendienteProducto::firstOrCreate([
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
    public function show(PendienteProducto $pendienteProducto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PendienteProducto $pendienteProducto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PendienteProducto $pendienteProducto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PendienteProducto $pendienteProducto)
    {
        //
    }

    public function LoadPendienteProductos()    
    {
        $user = Auth::user();

        // Si el usuario es admin, obtiene todo. Sino, solo lo asignado a él.
        if ($user->hasRole('Admin')) {
            $pendienteProductos = PendienteProducto::with(['producto', 'users','detalles'])
                ->paginate(10);
        } else {
            $pendienteProductos = PendienteProducto::with(['producto', 'users','detalles'])
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
        $data = Pendientes::with([
        'pendienteProductos.producto',
        'pendienteProductos.detalles.detalleProducto'
    ])->findOrFail($id);
        return response()->json($data);
    }

    public function getAsignaciones($id)
    {
        $asignaciones = PendienteProducto::with(['producto', 'detalles.detalleProducto'])
            ->where('pendiente_id', $id)
            ->get();

        return response()->json($asignaciones);
    }

}
