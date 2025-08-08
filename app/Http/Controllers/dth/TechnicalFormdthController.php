<?php

namespace App\Http\Controllers\dth;

use App\Http\Controllers\Controller;
use App\Models\dth\TechnicalFormdth;
use App\Models\dth\Detalles_productodth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TechnicalFormdthController extends Controller
{
        public function __construct()
{
    $this->middleware('can:tecnico.index')->only('index');
    $this->middleware('can:tecnico.create')->only('create','store');
    $this->middleware('can:tecnico.edit')->only('edit','update');
    $this->middleware('can:tecnico.destroy')->only('destroy');
}
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
        if ($request->has('id')) {
            $id = $request->get('id');
            $data = TechnicalFormdth::find($id);

            if (!$data) {
                return response()->json(['message' => 'Pendiente no encontrado'], 404);
            }

            $data->update($request->all());

        } else {
            $request['user_id'] = auth()->id();
            $data = TechnicalFormdth::create($request->all());

            // Actualizar estado de STBs y SmartCards
            for ($i = 1; $i <= 4; $i++) {
                $stbField = "settopbox{$i}";
                $smartField = "smartcard{$i}";

                // 👉 Buscar por STB
                if ($request->filled($stbField)) {
                    $stbValue = $request->input($stbField);
                    $detalle = Detalles_productodth::where('stb', $stbValue)->first();

                    if ($detalle) {
                        $detalle->estado = 'A'; // o el estado que necesites
                        $detalle->save();
                    } else {
                        \Log::warning("STB no encontrado: " . $stbValue);
                    }
                }

                // 👉 Buscar por SmartCard
                if ($request->filled($smartField)) {
                    $smartValue = $request->input($smartField);
                    $detalle = Detalles_productodth::where('stb', $smartValue)->first();

                    if ($detalle) {
                        $detalle->estado = 'A'; // mismo estado
                        $detalle->save();
                    } else {
                        \Log::warning("SmartCard no encontrada: " . $smartValue);
                    }
                }
            }
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
