<?php

namespace App\Http\Controllers\dth;

use App\Http\Controllers\Controller;
use App\Models\Pendientedth;
use Illuminate\Http\Request;

class PendientedthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return view('tvdth.pendiente.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tvdth.pendiente.create');
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
            $data = Pendientedth::find($id);

            if (!$data) {
                return response()->json(['message' => 'Pendiente no encontrado'], 404);
            }

            // Solo campos permitidos para actualizar
           $data->update($request->all());
        } else {
            // Nuevo registro
            $request['user_id'] = auth()->id();

            $data = Pendientedth::create($request->all());
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
    public function show(Pendientedth $pendientedth)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('tvdth.pendiente.index', ['pendienteId' => $id]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pendientedth $pendientedth)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Pendientedth::destroy($id);        
        return [
            'success' => true,
            'message' => 'Resturado con éxito'
        ];
    }
       public function Listar()
{
    $pendientes = Pendientedth::with('user')->paginate(10); // Puedes cambiar el 10 por la cantidad de ítems por página

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

    public function asignardth(Request $request)
{
    $request->validate([
        'pendientes' => 'required|array',
        'user_id' => 'required|exists:users,id',
    ]);

    Pendientedth::whereIn('id', $request->pendientes)
        ->update(['user_id' => $request->user_id]);

    return response()->json(['message' => 'Asignación completa']);
}

    
}
