<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.empleados');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $empleado = new Empleado();
            $empleado->fecha_registro = $request->fecha_registro;
            $empleado->nombre = $request->nombre;
            $empleado->fecha_nacimiento = $request->fecha_nacimiento;
            $empleado->telefono = $request->telefono;
            $empleado->correo = $request->correo;
            $empleado->salario = $request->salario;
            $empleado->save();
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    //actualizar empleado
    public function update(Request $request)
    {
        try{
            $empleado = Empleado::findOrfail($request->id);
            $empleado->fecha_registro = $request->fecha_registro;
            $empleado->nombre = $request->nombre;
            $empleado->fecha_nacimiento = $request->fecha_nacimiento;
            $empleado->telefono = $request->telefono;
            $empleado->correo = $request->correo;
            $empleado->salario = $request->salario;
            $empleado->save();
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    //eliminar empleado
    public function destroy(Request $request)
    {
        try{
            $empleado = Empleado::findOrfail($request->id);
            $empleado->delete();
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    //mostrar empleado
    public function show()
    {
        try{
            $empleado = Empleado::all();
            return $empleado;
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
}
