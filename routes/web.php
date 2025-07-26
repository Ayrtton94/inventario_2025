<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\{
    RoleController,
    UserController,
    ExcelController,
    ProductController,
    AsignadoController,
    ImportarController,
    PendientesController,
    TxtToExcelController,
    TechnicalFormController,
    DetallesProductoController,
    PendienteProductoController,
    DetallePendienteProductoController
};
use App\Http\Controllers\dth\{
    PendientedthController, AsignadothController, ProductodthController, Detalles_productodthController
};

// Página principal
Route::get('/', function () {
    return view('auth.login');
});

// Autenticación
Auth::routes();

// Rutas protegidas
Route::middleware('auth')->group(function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    /**
     * USUARIOS Y ROLES
     */
    Route::resource('user', UserController::class)->names('users');
    Route::get('/listar/usuario', [UserController::class, 'Listar']);
    Route::get('/usuarios/listar', [UserController::class, 'ListarUser']);
    Route::get('/get/user/{id}', [UserController::class, 'getUser']);
    Route::get('/get/roles', [UserController::class, 'Roles']);

    Route::resource('roles', RoleController::class)->names('roles');
    Route::get('/listar/roles', [RoleController::class, 'Listar']);
    Route::get('/get/permission', [RoleController::class, 'Permission']);
    Route::get('/get/roles/{id}', [RoleController::class, 'getroles']);

    /**
     * PENDIENTES Y ASIGNACIONES
     */
    Route::resource('pendiente', PendientesController::class)->names('pendiente');
    Route::get('/listar/pendiente', [PendientesController::class, 'Listar']);
    Route::get('/get/pendiente/{id}', [PendientesController::class, 'getPendientes']);
    Route::post('/asignar/pendientes', [PendientesController::class, 'asignar']);

    Route::resource('asignado', AsignadoController::class)->names('asignado');
    Route::get('/listar/asignados', [AsignadoController::class, 'asignados']);

    Route::resource('asignar-producto', PendienteProductoController::class)->names('asignar.producto');
    Route::get('/pendiente/{id}/asignaciones', [PendienteProductoController::class, 'verAsignaciones']);
    Route::get('/api/pendiente/{id}/asignaciones', [PendienteProductoController::class, 'getAsignaciones']);
    Route::get('/api/pendiente/productos', [PendienteProductoController::class, 'LoadPendienteProductos']);

    /**
     * PRODUCTOS Y DETALLES
     */
    Route::resource('productos', ProductController::class)->names('productos');
    Route::get('/api/listar/producto', [ProductController::class, 'Listar']);
    Route::get('/get/producto/{id}', [ProductController::class, 'getProduct']);

    Route::resource('detalle_productos', DetallesProductoController::class)->names('detalle_productos');
    Route::get('/productos/buscar/{codigo}', [ProductController::class, 'buscarPorCodigo']);
    Route::get('/listar/detailproduct', [DetallesProductoController::class, 'listar']);
    Route::get('/listar/producto', [DetallesProductoController::class, 'Producto']);
    Route::get('/get/detailproduct/{id}', [DetallesProductoController::class, 'getDetalles']);
    Route::get('/productos/{id}/detalles', [DetallesProductoController::class, 'getDetalles']);

    /**
     * FORMULARIO TÉCNICO
     */
    Route::resource('tecnico', TechnicalFormController::class)->names('tecnico');
    Route::get('/tecnico/create/{cliente}', [TechnicalFormController::class, 'create']);
    Route::get('/listar/form_tect', [TechnicalFormController::class, 'Listar']);
    Route::get('/get/tecnico/{id}', [TechnicalFormController::class, 'getTecnico']);
    Route::get('/api/tecnico/actual', fn () => response()->json(auth()->user()));

    /**
     * IMPORTACIÓN DE ARCHIVOS
     */
    Route::get('/inventario', [TxtToExcelController::class, 'index']);
    Route::post('/convert-txt-to-excel', [TxtToExcelController::class, 'convert']);
    Route::post('/convertirTxtAExcel', [TxtToExcelController::class, 'convertirTxtAExcel']);

    Route::get('/importexcel', [ExcelController::class, 'index'])->name('importexcel');
    Route::post('/import-excel', [ExcelController::class, 'import']);

    Route::post('api/import.excel', [ImportarController::class, 'importarProductos']);
    Route::post('api/importdetalle.excel', [ImportarController::class, 'importarDetalleProductos']);

    /**
     * PENDIENTE DTH
     */
    Route::resource('pendientedth', PendientedthController::class)->names('pendientedth');
    Route::get('/listar/pendientedth', [PendientedthController::class, 'Listar']);
    Route::post('/asignardth/pendientedth', [PendientedthController::class, 'asignardth']);

/**
     * Asignados DTH
     */
    Route::resource('asignadoth', AsignadothController::class)->names('asignadoth');
    Route::get('/listar/asignadosdth', [AsignadothController::class, 'asignadosdth']);

    /**
     * PRODUCTOS Y DETALLES dth
     */
    Route::resource('productosdth', ProductodthController::class)->names('productosdth');
    Route::get('/listar/productosdth', [ProductodthController::class, 'Listar']);
    Route::get('/get/productosdth/{id}', [ProductodthController::class, 'getProduct']);
    
    Route::resource('detalles_productodth', Detalles_productodthController::class)->names('detalles_productodth');
    Route::get('/listar/detailproductodth', [Detalles_productodthController::class, 'listar']);
    Route::get('/listar/productodth', [Detalles_productodthController::class, 'Producto']);
    Route::get('/get/detailproductodth/{id}', [Detalles_productodthController::class, 'getDetalles']);
    Route::get('/productodth/{id}/detalles', [Detalles_productodthController::class, 'getDetalles']);

});
