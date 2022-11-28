<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\EmpleadoController;
use App\http\Controllers\PPDFController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/categorias',[CategoriaController::class, 'index'])->name("categorias");
Route::get('/categorias/all',[CategoriaController::class,'show']);
Route::post('/categorias/save',[CategoriaController::class,'store']);
Route::put('/categorias/update',[CategoriaController::class,'update']);
Route::post('/categorias/delete',[CategoriaController::class,'destroy']);


Route::get('/empleados',[EmpleadoController::class, 'index'])->name("empleados");
Route::get('/empleados/all',[EmpleadoController::class,'show']);
Route::post('/empleados/save',[EmpleadoController::class,'store']);
Route::put('/empleados/update',[EmpleadoController::class,'update']);
Route::post('/empleados/delete',[EmpleadoController::class,'destroy']);
Route::get('/empleados/pdf', [PDFEController::class, 'pdfEmpleados'])->name('pdfEmpleados');

Route::get('/reportes/prestamos/rango',[PPDFController::class,'pdfPrestamos'])->name('pdfPrestamos');