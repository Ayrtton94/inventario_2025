<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Detalles_producto;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
{
    $this->middleware('can:producto.index')->only('index');
    $this->middleware('can:producto.create')->only('create','store');
    $this->middleware('can:producto.edit')->only('edit','update');
    $this->middleware('can:producto.destroy')->only('destroy');
}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('producto.index');
    }

    
    public function create()
    {
        return view('producto.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->get('id')){

            $id = $request->get('id');

            $data = Product::find($id);

            $data->update($request->all());
    
        }else{
            //$request['user_id'] = auth()->id();
            $data = Product::create($request->all());
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
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
       return view('producto.edit', ['productoId' => $id]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }

    public function listar()
{
    // Cargar relación con conteo
    $productos = Product::withCount('detalles')->paginate(10);

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
        $data = Product::find($id);
        return response()->json($data, 200);
    }

    
}
