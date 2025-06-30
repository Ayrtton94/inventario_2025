<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
{
    $this->middleware('can:user.index')->only('index');
    $this->middleware('can:user.edit')->only('edit');
    $this->middleware('can:user.update');
}
   

    public function index()
    {
       return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->get('id')){

            $id = $request->get('id');

            $data = User::find($id);

            $data->update($request->all());
    
        }else{
            //$request['user_id'] = auth()->id();
            $data = User::create($request->all());
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
       return view('users.edit', ['usuariosId' => $id]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        // Suponiendo que usás relación muchos a muchos con roles
        $user->roles()->sync($request->roles);

        return response()->json(['message' => 'Usuario actualizado con éxito']);
        }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::destroy($id);        
        return [
            'success' => true,
            'message' => 'Resturado con éxito'
        ];
    }

    public function Roles()
    {
        $data = Role::all();
        return response()->json($data, 200);
    }

    public function getUser($id){
        $data = User::find($id);
        return response()->json($data, 200);
    }

    public function Listar()
    {
        $usuarios = User::paginate(5); // Puedes cambiar el 10 por la cantidad de ítems por página

        // Transformamos los datos si es necesario
        $data = $usuarios->map(function ($usuario) {
            return [
                'id' => $usuario->id,
                'name'=> $usuario->name,
                'email'=> $usuario->email
            ];
        });

        return response()->json([
            'data' => $data,
            'current_page' => $usuarios->currentPage(),
            'last_page' => $usuarios->lastPage(),
            'per_page' => $usuarios->perPage(),
            'total' => $usuarios->total(),
        ], 200);
    }

    public function ListarUser()
    {
        $usuarios = User::get(); 
        $data = $usuarios->map(function ($usuario) {
            return [
                'id' => $usuario->id,
                'name'=> $usuario->name,
                'email'=> $usuario->email
            ];
        });
        return response()->json($data, 200);
    }


}
