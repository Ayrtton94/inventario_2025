<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AsignadoController;
use App\Http\Controllers\ImportarController;
use App\Http\Controllers\PendientesController;
use App\Http\Controllers\TxtToExcelController;
use App\Http\Controllers\TechnicalFormController;
use App\Http\Controllers\DetallesProductoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function() {

    Route::resource('user', UserController::class)->names('users');
    
    Route::resource('pendiente', PendientesController::class)->names('pendiente');
    Route::resource('productos', ProductController::class)->names('productos');
    Route::resource('detalle_productos', DetallesProductoController::class)->names('detalle_productos');
    Route::resource('roles', RoleController::class)->names('roles');
    Route::resource('tecnico', TechnicalFormController::class)->names('tecnico');
    Route::resource('asignado', AsignadoController::class)->names('asignado');
    Route::get('/listar/asignados', [AsignadoController::class, 'asignado']);

    Route::get('/tecnico/create/{cliente}', [TechnicalFormController::class, 'create']);

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');    
    Route::get('/inventario', [TxtToExcelController::class,  'index']);
    Route::get('/importexcel', [ExcelController::class, 'index'])->name('importexcel');

    Route::post('/convert-txt-to-excel', [TxtToExcelController::class, 'convert']);
    Route::post('/convertirTxtAExcel', [TxtToExcelController::class, 'convertirTxtAExcel']);
    
    Route::post('/import-excel', [ExcelController::class, 'import']);
    Route::post('api/import.excel', [ImportarController::class, 'importarProductos']);
    Route::post('api/importdetalle.excel', [ImportarController::class, 'importarDetalleProductos']);

    //api
    Route::get('/listar/pendiente', [PendientesController::class, 'Listar']);
    Route::get('/get/pendiente/{id}', [PendientesController::class, 'getPendientes']);
    Route::post('/asignar/pendientes', [PendientesController::class, 'asignar']);

    Route::get('/api/listar/producto', [ProductController::class, 'Listar']);
    Route::get('/get/producto/{id}', [ProductController::class, 'getProduct']);

    Route::get('/listar/detailproduct', [DetallesProductoController::class, 'listar']);
    Route::get('/listar/producto', [DetallesProductoController::class, 'Producto']);
    Route::get('/get/detailproduct/{id}', [DetallesProductoController::class, 'getDetalles']);

    Route::get('/listar/usuario', [UserController::class, 'Listar']);
    Route::get('/usuarios/listar', [UserController::class, 'ListarUser']);
    Route::get('/get/user/{id}', [UserController::class, 'getUser']); 
    Route::get('/get/roles', [UserController::class, 'Roles']); 

    Route::get('/listar/roles', [RoleController::class, 'Listar']);
    Route::get('/get/permission', [RoleController::class, 'Permission']); 

    Route::get('/listar/form_tect', [TechnicalFormController::class, 'Listar']);
    Route::get('/get/tecnico/{id}', [TechnicalFormController::class, 'getTecnico']);
    Route::get('/api/tecnico/actual', function () {
            return response()->json(auth()->user());
        });

});