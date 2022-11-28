<?php

use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\BodegaController;
use App\Http\Controllers\PrestamoController;

//ananido 7/10/2022
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ReporteController;

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DescargoController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\AsignacionController;
use App\Http\Controllers\AlquilerController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\MantenimientoController;
use App\Http\Controllers\RecursoeController;
use App\Http\Controllers\TipoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


//PDF
//Compras
use App\Http\Controllers\PDFController;
//bodegas
use App\Http\Controllers\PDFBController;
//Empleados
use App\Http\Controllers\PDFEController;
//Clientes
use App\Http\Controllers\PDFCController;
//Proyectos
use App\Http\Controllers\PDFPController;
//Asignacion
use App\Http\Controllers\PDFASController;
//Alquiler
use App\Http\Controllers\PDFAController;
//Grupo
use App\Http\Controllers\PDFGController;
//Mantenimiento
use App\Http\Controllers\PDFMController;
//Descargo
use App\Http\Controllers\PDFDController;

///reportePrestamo
use App\Http\Controllers\PPDFController;

//controlador de graficos
use App\Http\Controllers\ChartController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//ananido 7/10/2022
Route::get('/reporte', [App\Http\Controllers\ReporteController::class, 'index'])->name('reporte');



Route::get('/',HomeController::class)->name("home");
Auth::routes();

Route::get('/admin', [HomeController::class, 'index'])->name("admin-index")->middleware('auth.admin');

//Categorias
Route::get('/proveedores',[ProveedorController::class,'index'])->name("proveedores")->middleware('auth.admin');
Route::get('/proveedores/all',[ProveedorController::class,'show']);
Route::post('/proveedores/save',[ProveedorController::class,'store']);
Route::put('/proveedores/update',[ProveedorController::class,'update']);
Route::post('/proveedores/delete',[ProveedorController::class,'destroy']);

//Marcas
Route::get('/marcas',[MarcaController::class,'index'])->name("marcas")->middleware('auth.admin');
Route::get('/marcas/all',[MarcaController::class,'show']);
Route::post('/marcas/save',[MarcaController::class,'store']);
Route::put('/marcas/update',[MarcaController::class,'update']);
Route::post('/marcas/delete',[MarcaController::class,'destroy']);

//Cragos
Route::get('/cargos',[CargoController::class, 'index'])->name("cargos")->middleware('auth.admin');
Route::get('/cargos/all',[CargoController::class,'show']);
Route::post('/cargos/save',[CargoController::class,'store']);
Route::put('/cargos/update',[CargoController::class,'update']);
Route::post('/cargos/delete',[CargoController::class,'destroy']);

Route::get('/empleados',[EmpleadoController::class, 'index'])->name("empleados")->middleware('auth.admin');
Route::get('/empleados/all',[EmpleadoController::class,'show']);
Route::post('/empleados/save',[EmpleadoController::class,'store']);
Route::put('/empleados/update',[EmpleadoController::class,'update']);
Route::post('/empleados/delete',[EmpleadoController::class,'destroy']);
Route::get('/empleados/pdf', [PDFEController::class, 'pdfEmpleados'])->name('pdfEmpleados');

//Bodegas
Route::get('/bodegas',[BodegaController::class,'index'])->name("bodegas")->middleware('auth.admin');
Route::get('/bodegas/all',[BodegaController::class,'show']);
Route::post('/bodegas/save',[BodegaController::class,'store']);
Route::put('/bodegas/update',[BodegaController::class,'update']);
Route::post('/bodegas/delete',[BodegaController::class,'destroy']);
Route::get('/bodegas/pdf', [PDFBController::class, 'pdfBodegas'])->name('pdfBodegas')->middleware('auth.admin');

//ruta para metodos de crud prestamos
Route::get('/prestamos',[PrestamoController::class,'index'])->name("prestamos")->middleware('auth.admin');
Route::get('/prestamos/state',[PrestamoController::class,'show']);
Route::post('/prestamos/save',[PrestamoController::class,'store']);
Route::put('/prestamos/change',[PrestamoController::class,'changeState']);
//ruta para ver reservas
Route::get('/reservas/user',[PrestamoController::class,'viewByUser'])->name("reservas.user");
//ruta para reporte parametrizado
Route::get('/reportes/prestamos',[PrestamoController::class,'viewPrestamos'])->name('report.prestamos');
Route::get('/reportes/prestamos/rango',[PPDFController::class,'pdfPrestamos'])->name('pdfPrestamos');
//rutas para el reporte de graficas
Route::get('/graficos',[ChartController::class,'index'])->name("graficos.prestamos");
Route::get('/graficos/bars',[ChartController::class,'bars'])->name("bars.prestamos");
Route::get('/prestamos/chart',[ChartController::class,'bars'])->name("chart.prestamos");


Route::get('/proyectos',[ProyectoController::class, 'index'])->name('proyectos')->middleware('auth.admin');
Route::get('/proyectos/all',[ProyectoController::class,'show']);
Route::post('/proyectos/save',[ProyectoController::class,'store']);
Route::put('/proyectos/update',[ProyectoController::class,'update']);
Route::post('/proyectos/delete',[ProyectoController::class,'destroy']);
//ruta para reporte
Route::get('/reportes/proyectos',[ProyectoController::class,'viewProyectos'])->name('report.proyectos');
Route::get('/reportes/proyectos/rango',[PDFPController::class,'pdfProyectos'])->name('pdfProyectos');



Route::get('/compras',[CompraController::class,'index'])->name('compras')->middleware('auth.admin');
Route::get('/compras/all',[CompraController::class,'show']);
Route::post('/compras/save',[CompraController::class,'store']);
Route::put('/compras/update',[CompraController::class,'update']);
Route::post('/compras/delete',[CompraController::class,'destroy']);
//ruta para reporte
Route::get('/reportes/compras',[CompraController::class,'viewCompras'])->name('report.compras');
Route::get('/reportes/compras/rango',[PDFController::class,'pdfCompras'])->name('pdfCompras');




Route::get('/clientes',[ClienteController::class,'index'])->name("clientes")->middleware('auth.admin');
Route::get('/clientes/all',[ClienteController::class,'show']);
Route::post('/clientes/save',[ClienteController::class,'store']);
Route::put('/clientes/update',[ClienteController::class,'update']);
Route::post('/clientes/delete',[ClienteController::class,'destroy']);
Route::get('/clientes/pdf', [PDFCController::class, 'pdfClientes'])->name('pdfClientes');


Route::get('/descargos',[DescargoController::class, 'index'])->name("descargos")->middleware('auth.admin');
Route::get('/descargos/all',[DescargoController::class,'show']);
Route::post('/descargos/save',[DescargoController::class,'store']);
Route::put('/descargos/update',[DescargoController::class,'update']);
Route::post('/descargos/delete',[DescargoController::class,'destroy']);
//ruta para reporte
Route::get('/reportes/descargos',[DescargoController::class,'viewDescargos'])->name('report.descargos');
Route::get('/reportes/descargos/rango',[PDFDController::class,'pdfDescargos'])->name('pdfDescargos');




/*Route::resource('/categorias',CategoriaController::class)->middleware('auth.admin');*/

Route::get('/categorias',[CategoriaController::class, 'index'])->name("categorias")->middleware('auth.admin');
Route::get('/categorias/all',[CategoriaController::class,'show']);
Route::post('/categorias/save',[CategoriaController::class,'store']);
Route::put('/categorias/update',[CategoriaController::class,'update']);
Route::post('/categorias/delete',[CategoriaController::class,'destroy']);


Route::get('/equipos',[EquipoController::class, 'index'])->name('equipos')->middleware('auth.admin');
Route::get('/equipos/all',[EquipoController::class,'show']);
Route::post('/equipos/save',[EquipoController::class,'store']);
Route::put('/equipos/update',[EquipoController::class,'update']);
Route::post('/equipos/delete',[EquipoController::class,'destroy']);


Route::get('/asignaciones',[AsignacionController::class, 'index'])->name('asignaciones')->middleware('auth.admin');
Route::get('/asignaciones/all',[AsignacionController::class,'show']);
Route::post('/asignaciones/save',[AsignacionController::class,'store']);
Route::put('/asignaciones/update',[AsignacionController::class,'update']);
Route::post('/asignaciones/delete',[AsignacionController::class,'destroy']);
Route::get('/asignaciones/pdf', [PDFASController::class, 'pdfAsignaciones'])->name('pdfAsignaciones');


Route::get('/alquileres',[AlquilerController::class, 'index'])->name('alquileres')->middleware('auth.admin');
Route::get('/alquileres/all',[AlquilerController::class,'show']);
Route::post('/alquileres/save',[AlquilerController::class,'store']);
Route::put('/alquileres/update',[AlquilerController::class,'update']);
Route::post('/alquileres/delete',[AlquilerController::class,'destroy']);
Route::get('/alquileres/pdf', [PDFAController::class, 'pdfAlquileres'])->name('pdfAlquileres');
//reporte para reporte
Route::get('/reportes/alquileres',[AlquilerController::class,'viewAlquileres'])->name('report.alquileres');
Route::get('/reportes/alquileres/rango',[PDFAController::class,'pdfAlquileres'])->name('pdfAlquileres');



// para equipos
Route::get('/grupos',[GrupoController::class,'index'])->name('grupos')->middleware('auth.admin');
Route::get('/grupos/all',[GrupoController::class,'show']);
Route::post('/grupos/save',[GrupoController::class,'store']);
Route::put('/grupos/update',[GrupoController::class,'update']);
Route::post('/grupos/delete',[GrupoController::class,'destroy']);
Route::get('/grupos/pdf', [PDFGController::class, 'pdfGrupos'])->name('pdfGrupos');


Route::get('/mantenimientos',[MantenimientoController::class,'index'])->name('mantenimientos')->middleware('auth.admin');
Route::get('/mantenimientos/all',[MantenimientoController::class,'show']);
Route::post('/mantenimientos/save',[MantenimientoController::class,'store']);
Route::put('/mantenimientos/update',[MantenimientoController::class,'update']);
Route::post('/mantenimientos/delete',[MantenimientoController::class,'destroy']);
//ruta para reporte
Route::get('/reportes/mantenimientos',[MantenimientoController::class,'viewMantenimientos'])->name('report.mantenimientos');
Route::get('/reportes/mantenimientos/rango',[PDFMController::class,'pdfMantenimientos'])->name('pdfMantenimientos');


Route::get('/recursoes',[RecursoeController::class,'index'])->name('recursoes')->middleware('auth.admin');
Route::get('/recursoes/all',[RecursoeController::class,'show']);
Route::post('/recursoes/save',[RecursoeController::class,'store']);
Route::put('/recursoes/update',[RecursoeController::class,'update']);
Route::post('/recursoes/delete',[RecursoeController::class,'destroy']);

//tipoos
Route::get('/tipos',[TipoController::class,'index'])->name("tipos")->middleware('auth.admin');
Route::get('/tipos/all',[TipoController::class,'show']);
Route::post('/tipos/save',[TipoController::class,'store']);
Route::put('/tipos/update',[TipoController::class,'update']);
Route::post('/tipos/delete',[TipoController::class,'destroy']);
 