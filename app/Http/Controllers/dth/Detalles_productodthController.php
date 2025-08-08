<?php

namespace App\Http\Controllers\dth;

use App\Models\dth\Detalles_productodth;
use App\Models\dth\Productodth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Detalles_productodthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('tvdth.detalle_producto.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tvdth.detalle_producto.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    try {
        // Si viene con ID, actualiza
        if ($request->has('id')) {
            $id = $request->get('id');
            $data = Detalles_productodth::find($id);

            if (!$data) {
                return response()->json(['message' => 'Detalle no encontrado'], 404);
            }

            // Solo campos permitidos para actualizar
           $data->update($request->all());
        } else {

            $data = Detalles_productodth::create($request->all());
        }

        return response()->json($data, 200);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Error al crear o actualizar',
            'error' => $e->getMessage()
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
    public function edit($id)
    {
        return view('tvdth.detalle_producto.edite', ['detailproductId' => $id]);
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

public function listar()
{
    // Paginamos los detalles cuyo estado no sea 'A'
    $detalles_productos = Detalles_productodth::where('estado', '!=', 'A')->paginate(10);

    // Transformamos cada item del paginado
    $data = $detalles_productos->items(); // Ya devuelve los items sin necesidad de map si no vas a modificar

    return response()->json([
        'data' => $data,
        'current_page' => $detalles_productos->currentPage(),
        'last_page' => $detalles_productos->lastPage(),
        'per_page' => $detalles_productos->perPage(),
        'total' => $detalles_productos->total(),
    ], 200);
}

     public function Producto()
    {
        try {
            $productos = Productodth::select('id','cod_producto','producto')
            ->get();
            return response()->json($productos);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al cargar las productos',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function getDetalles($id){
        $data = Detalles_productodth::select('id','cod_art','stb')
        ->where('cod_art', $id)->get();
        return response()->json($data, 200);
    }


    public function fetchDetalles($id){
        $data = Detalles_productodth::find($id);
        return response()->json($data, 200);
    }
}
