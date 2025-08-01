<?php

namespace App\Http\Controllers;

use App\Models\TechnicalForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TechnicalFormController extends Controller
{
    public function __construct()
{
    $this->middleware('can:tecnico.index')->only('index');
    $this->middleware('can:tecnico.create')->only('create','store');
    $this->middleware('can:tecnico.edit')->only('edit','update');
    $this->middleware('can:tecnico.destroy')->only('destroy');
}
    
    
    public function index()
    {
        return view('tecnico.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
         $tecnico = auth()->user();
       return view('tecnico.create', [
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
            $data = TechnicalForm::find($id);

            if (!$data) {
                return response()->json(['message' => 'Pendiente no encontrado'], 404);
            }

            // Solo campos permitidos para actualizar
           $data->update($request->all());
        } else {
            // Nuevo registro
            $request['user_id'] = auth()->id();

            $data = TechnicalForm::create($request->all());
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
    public function show(TechnicalForm $technicalForm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('tecnico.edit', ['tecnicoId' => $id]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TechnicalForm $technicalForm)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        TechnicalForm::destroy($id);        
        return [
            'success' => true,
            'message' => 'Resturado con éxito'
        ];
    }

    public function listar()
    {
        $userId = Auth::id();
        $forms = TechnicalForm::where('user_id', $userId)->paginate(10);

        $data = $forms->map(function ($form) {
            return [
                'id' => $form->id,
                'abonado'=> $form->abonado,
                'fecha_ingreso'=> $form->fecha_ingreso,
                'pendiente_id'=> $form->pendiente_id,
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
        $data = TechnicalForm::find($id);
        return response()->json($data, 200);
    }

}
