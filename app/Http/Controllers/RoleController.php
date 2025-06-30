<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function __construct()
{
    $this->middleware('can:roles.index')->only('index');
    $this->middleware('can:roles.create')->only('create','store');
    $this->middleware('can:roles.edit')->only('edit','update');
    $this->middleware('can:roles.destroy')->only('destroy');
}
    
    public function index()
    {
        return view ('roles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar datos
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        // Crear rol
        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web', // asegúrate de usar el guard correcto
        ]);

        // Sincronizar permisos
        $role->permissions()->sync($request->permissions);

        return response()->json([
            'message' => 'Rol creado correctamente',
            'role' => $role
        ], 201);
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
        return view ('roles.edit', ['rolesId' => $id]);
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

    public function Listar()
    {
        $usuarios = Role::paginate(5); // Puedes cambiar el 10 por la cantidad de ítems por página

        // Transformamos los datos si es necesario
        $data = $usuarios->map(function ($usuario) {
            return [
                'id' => $usuario->id,
                'name'=> $usuario->name
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

    public function Permission()
    {
        $data = Permission::all();
        return response()->json($data, 200);
    }

}
