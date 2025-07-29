<?php

namespace App\Http\Controllers\dth;

use Illuminate\Http\Request;
use App\Models\dth\Productodth;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\dth\DetallePendienteProductodth;

class ProductodthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('tvdth.producto.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tvdth.producto.create');
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    $validated = $request->validate([
        'cod_producto' => 'required|unique:productodths,cod_producto',
        'producto' => 'required|string',
        'cantidad' => 'required|integer|min:0',
    ]);

    try {
        $data = Productodth::create($validated);

        return response()->json($data, 200);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Error al crear',
            'error' => $e->getMessage(),
        ], 500);
    }
}


    /**
     * Display the specified resource.
     */
    public function show(Productodth $productodth)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('tvdth.producto.edite', ['productoId' => $id]);
    }

    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, $id)
{
    $producto = Productodth::findOrFail($id);

    $validated = $request->validate([
        // Solo valida cod_producto si cambió
        'producto' => 'required|string',
        'cantidad' => 'required|integer|min:0',
    ]);

    // Si deseas permitir cambiar cod_producto, puedes agregar lógica condicional aquí
    $producto->update($validated);

    return response()->json(['message' => 'Producto actualizado correctamente', 'producto' => $producto]);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Productodth $productodth)
    {
        //
    }

    public function listar()
{
    // Cargar relación con conteo
    $productos = Productodth::withCount('detallesdth')->paginate(10);

    $data = $productos->map(function ($producto) {
        return [
            'id' => $producto->id,
            'cod_producto' => $producto->cod_producto,
            'producto' => $producto->producto,
            'cantidad' => $producto->cantidad,
            'total_detalles' => $producto->detalles_count // Aquí el conteo
        ];
    });

    return response()->json([
        'data' => $data,
        'current_page' => $productos->currentPage(),
        'last_page' => $productos->lastPage(),
        'per_page' => $productos->perPage(),
        'total' => $productos->total(),
    ], 200);
}

public function getProduct($id){
        $data = Productodth::find($id);
        return response()->json($data, 200);
    }

    public function buscarPorCodigo($codigo)
    {
        $producto = Productodth::where('cod_producto', $codigo)->first();

        if (!$producto) {
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }

        // Obtener los IDs de los detalles ya asignados
        $detallesAsignados = DetallePendienteProductodth::pluck('detalle_producto_id')->toArray();

        // Filtrar detalles del producto que no estén asignados
        $detallesDisponibles = $producto->detallesdth()->whereNotIn('id', $detallesAsignados)->get();

        return response()->json([
            'producto' => $producto,
            'detalles' => $detallesDisponibles,
        ]);
    }


}
