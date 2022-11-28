<?php

namespace App\Http\Controllers;
use App\Models\Asignacion;
use Illuminate\Http\Request;

class AsignacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.asignaciones');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $asignacion = new Asignacion();
            $asignacion->presupuesto_i = $request->presupuesto_i;
            $asignacion->gasto_f = $request->gasto_f;
            $asignacion->cantidad = $request->cantidad;
            $asignacion->fecha = $request->fecha;
            $asignacion->equipo_id = $request->equipo_id;
            $asignacion->proyecto_id = $request->proyecto_id;
            if($asignacion->save()>=1){
            return response()->json(['status'=>'ok','data'=>$asignacion],201);
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
            $asignaciones = Asignacion::join('equipos','asignaciones.equipo_id','=','equipos.id')
            ->join('proyectos','asignaciones.proyecto_id','=','proyectos.id')
            ->select('asignaciones.id','asignaciones.presupuesto_i','asignaciones.gasto_f','asignaciones.cantidad','asignaciones.fecha','asignaciones.equipo_id','equipos.nombre as equipo','asignaciones.proyecto_id','proyectos.nombre as proyecto')
            ->orderBy('asignaciones.id','DESC')->get();
            return $asignaciones;
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
            $asignacion = Asignacion::findOrfail($request->id);
            $asignacion->presupuesto_i = $request->presupuesto_i;
            $asignacion->gasto_f = $request->gasto_f;
            $asignacion->cantidad = $request->cantidad;
            $asignacion->fecha = $request->fecha;
            $asignacion->equipo_id = $request->equipo_id;
            $asignacion->proyecto_id = $request->proyecto_id;
            if($asignacion->save()>=1){
            return response()->json(['status'=>'ok','data'=>$asignacion],202);
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
            $asignacion = Asignacion::findOrfail($request->id);
            $asignacion->delete();
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
}
