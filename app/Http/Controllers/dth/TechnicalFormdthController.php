<?php

namespace App\Http\Controllers\dth;

use App\Http\Controllers\Controller;
use App\Models\dth\TechnicalFormdth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TechnicalFormdthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('tvdth.technicalform.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $tecnico = auth()->user();
        return view('tvdth.technicalform.create', [
            'clienteId' => $id,
            'tecnicoId' => $tecnico->id,
        ]);
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
            $data = TechnicalFormdth::find($id);

            if (!$data) {
                return response()->json(['message' => 'Formulario no encontrado'], 404);
            }

            // Solo campos permitidos para actualizar
           $data->update($request->all());
        } else {
            // Nuevo registro
            $request['user_id'] = auth()->id();

            $data = TechnicalFormdth::create($request->all());
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
        return view('tvdth.technicalform.edite', ['tecnicoId' => $id]);
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
        $userId = Auth::id();
        $forms = TechnicalFormdth::where('user_id', $userId)->paginate(10);

        $data = $forms->map(function ($form) {
            return [
                'id' => $form->id,
                'abonado'=> $form->abonado,
                'fecha_ingreso'=> $form->fecha_ingreso,
                'pendientedths_id'=> $form->pendientedths_id,
                'nombre'=> $form->nombre,
                'direccion'=> $form->direccion,
                'comuna'=> $form->comuna,
                'ciudad'=> $form->ciudad,
                'rut'=> $form->rut,
                'fono'=> $form->fono,
                'celular'=> $form->celular,
                'user_id'=> $form->user_id,
                'rut_tecnico'=> $form->rut_tecnico,
                'empresa'=> $form->empresa
            ];
        });

        return response()->json([
            'data' => $data,
            'current_page' => $forms->currentPage(),
            'last_page' => $forms->lastPage(),
            'per_page' => $forms->perPage(),
            'total' => $forms->total(),
        ], 200);
    }

    public function getTecnico($id){
        $data = TechnicalFormdth::find($id);
        return response()->json($data, 200);
    }


}
