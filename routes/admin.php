<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;

//ananido 7/10/2022
use App\Http\Controllers\Admin\CuentaController;
//use App\Http\Controllers\Admin\HomeController as ControllerHomeController;

//ruta para cargar la index de admin

Route::get('',[HomeController::class,'index'])->name('admin-index');

//ananido 7/10/2022
Route::get('',[Cuentaller::class,'index'])->name('admin-index');