<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grupo;


class GrupoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.grupos');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $grupo = new Grupo();
            $grupo->fecha = $request->fecha;
            $grupo->cargo_id = $request->cargo_id;
            $grupo->empleado_id = $request->empleado_id;
            $grupo->proyecto_id = $request->proyecto_id;
            if($grupo->save()>=1){
            return response()->json(['status'=>'ok','data'=>$grupo],201);
            }
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        try{
            $grupos = Grupo::join('cargos','grupos.cargo_id','=','cargos.id')
            ->join('empleados','grupos.empleado_id','=','empleados.id')
            ->join('proyectos','grupos.proyecto_id','=','proyectos.id')
            ->select('grupos.id','grupos.fecha','grupos.cargo_id','cargos.nombre as cargo','grupos.empleado_id','empleados.nombre as empleado','grupos.proyecto_id','proyectos.nombre as proyecto')
            ->orderBy('grupos.id','DESC')->get();
            return $grupos;
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try{
            $grupo = Grupo::findOrfail($request->id);
            $grupo->fecha = $request->fecha;
            $grupo->cargo_id = $request->cargo_id;
            $grupo->empleado_id = $request->empleado_id;
            $grupo->proyecto_id = $request->proyecto_id;
            $grupo->save();
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try{
            $grupo = Grupo::findOrfail($request->id);
            $grupo->delete();
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
}
