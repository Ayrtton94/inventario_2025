<?php

namespace App\Http\Controllers;

use App\Models\Pendientes;
use Illuminate\Http\Request;

class PendientesController extends Controller
{
    public function __construct()
{
    $this->middleware('can:cliente.index')->only('index');
    $this->middleware('can:cliente.create')->only('create','store');
    $this->middleware('can:cliente.edit')->only('edit','update');
    $this->middleware('can:cliente.destroy')->only('destroy');
}
    
    public function index()
    {
        return view('pendiente.index');
    }

   public function Listar()
{
    $pendientes = Pendientes::with('user')->paginate(10); // Puedes cambiar el 10 por la cantidad de ítems por página

    // Transformamos los datos si es necesario
    $data = $pendientes->map(function ($pendiente) {
        return [
            'id' => $pendiente->id,
            'departamento'=> $pendiente->departamento,
            'provincia'=> $pendiente->provincia,
            'municipio'=> $pendiente->municipio,
            'direccion'=> $pendiente->direccion,
            'abonado'=> $pendiente->abonado,
            'nombres'=> $pendiente->nombres,
            'tlf_habitacion'=> $pendiente->tlf_habitacion,
            'tlf_movil'=> $pendiente->tlf_movil,
            'dth'=> $pendiente->dth,
            'cnt_equipos'=> $pendiente->cnt_equipos,
            'tipo_instalacion'=> $pendiente->tipo_instalacion,
            'fecha_ingreso'=> $pendiente->fecha_ingreso,
            'fecha_age'=> $pendiente->fecha_age,
            'distribuidor_age'=> $pendiente->distribuidor_age,
            'tipo_cliente_grupo_afinidad'=> $pendiente->tipo_cliente_grupo_afinidad,
            'origen_abonado'=> $pendiente->origen_abonado,
            'user' => $pendiente->user ? [
                'id' => $pendiente->user->id,
                'name' => $pendiente->user->name
            ] : null, // Agregado para mostrar el usuario asignado
            'url_edit' => route('pendiente.edit', $pendiente->id),
        ];
    });

    return response()->json([
        'data' => $data,
        'current_page' => $pendientes->currentPage(),
        'last_page' => $pendientes->lastPage(),
        'per_page' => $pendientes->perPage(),
        'total' => $pendientes->total(),
    ], 200);
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pendiente.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       if ($request->get('id')){

            $id = $request->get('id');

            $data = Pendientes::find($id);

            $data->update($request->all());
    
        }else{
            //$request['user_id'] = auth()->id();
            $data = Pendientes::create($request->all());
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
    public function show(Pendientes $pendientes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('pendiente.edite', ['pendienteId' => $id]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pendientes $pendientes)
    {
        //
    }    

    public function destroy($id)
    {
        Pendientes::destroy($id);        
        return [
            'success' => true,
            'message' => 'Resturado con éxito'
        ];
    }

     public function getPendientes($id){
        $data = Pendientes::find($id);
        return response()->json($data, 200);
    }

    public function asignar(Request $request)
{
    $request->validate([
        'pendientes' => 'required|array',
        'user_id' => 'required|exists:users,id',
    ]);

    Pendientes::whereIn('id', $request->pendientes)
        ->update(['user_id' => $request->user_id]);

    return response()->json(['message' => 'Asignación completa']);
}

}
