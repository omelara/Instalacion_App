<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mantenimiento;

class MantenimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.mantenimientos');
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
            $mantenimiento = new Mantenimiento();
            $mantenimiento->observacion = $request->observacion;
            $mantenimiento->fecha = $request->fecha;
            $mantenimiento->encargado = $request->encargado;
            $mantenimiento->equipo_id = $request->equipo_id;
            if($mantenimiento->save()>=1){
            return response()->json(['status'=>'ok','data'=>$mantenimiento],201);
            }
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        try{
            $mantenimientos = Mantenimiento::join('equipos','mantenimientos.equipo_id','=','equipos.id')
            ->select('mantenimientos.id','mantenimientos.observacion','mantenimientos.fecha','mantenimientos.encargado','mantenimientos.equipo_id','equipos.nombre as equipo')
            ->orderBy('mantenimientos.id','DESC')->get();
            return $mantenimientos;
        }catch(\Exception $e){
            return $e->getMessage();
        }
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
            $mantenimiento = Mantenimiento::findOrfail($request->id);
            $mantenimiento->observacion = $request->observacion;
            $mantenimiento->fecha = $request->fecha;
            $mantenimiento->encargado = $request->encargado;
            $mantenimiento->equipo_id = $request->equipo_id;
            if($mantenimiento->save()>=1){
            return response()->json(['status'=>'ok','data'=>$mantenimiento],202);
            }
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
            $mantenimiento = Mantenimiento::findOrfail($request->id);
            $mantenimiento->delete();
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

       ///para reporte parametrizado
       public function viewMantenimientos(){
        return view('admin.rmantenimientos');
    }
}
