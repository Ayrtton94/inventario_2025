<?php

namespace App\Http\Controllers;

use App\Models\Detalles_producto;
use App\Models\Product;
use Illuminate\Http\Request;

class DetallesProductoController extends Controller
{
    public function __construct()
{
    $this->middleware('can:detalle_producto.index')->only('index');
    $this->middleware('can:detalle_producto.create')->only('create','store');
    $this->middleware('can:detalle_producto.edit')->only('edit','update');
    $this->middleware('can:detalle_producto.destroy')->only('destroy');
}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('detalle_producto.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('detalle_producto.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->get('id')){

            $id = $request->get('id');

            $data = Detalles_producto::find($id);

            $data->update($request->all());
    
        }else{
            //$request['user_id'] = auth()->id();
            $data = Detalles_producto::create($request->all());
        }

        if ($data) {
            return response()->json($data, 200);
        } else {
            return response()->json(['message' => 'Error al crear'], 402);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Detalles_producto $detalles_producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('detalle_producto.edit', ['detailproductId' => $id]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Detalles_producto $detalles_producto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Detalles_producto $detalles_producto)
    {
        //
    }

     public function listar()
    {
         $detalles_productos = Detalles_producto::paginate(10);
         
        $data = $detalles_productos->map(function ($detalles_producto) {
            return [
                'id' => $detalles_producto->id,
                'fecha_ingreso'=> $detalles_producto->fecha_ingreso,         
                'stb'=> $detalles_producto->stb,
                'cod_art'=> $detalles_producto->cod_art,
                'estado'=> $detalles_producto->estado
            ];
        });

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
            $productos = Product::select('id','cod_producto','producto')
            ->get();
            return response()->json($productos);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al cargar las productos',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    /*public function getDetalles($id){
        $data = Detalles_producto::select('id','cod_art','stb')
         ->where('producto_id', $id)->get();
        return response()->json($data, 200);
    }*/
    public function getDetalles($id){
        $data = Detalles_producto::select('id','cod_art','stb')
        ->where('cod_art', $id)->get();
        return response()->json($data, 200);
    }


    public function fetchDetalles($id){
        $data = Detalles_producto::find($id);
        return response()->json($data, 200);
    }

}
