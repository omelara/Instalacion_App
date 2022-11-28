<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proyecto;

class ProyectoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.proyectos');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $proyecto = new Proyecto();
            $proyecto->nombre = $request->nombre;
            $proyecto->descripcion = $request->descripcion;
            $proyecto->fecha_inicio = $request->fecha_inicio;
            $proyecto->fecha_fin = $request->fecha_fin;
            $proyecto->estado = $request->estado;
            $proyecto->cliente_id = $request->cliente_id;
            if($proyecto->save()>=1){
            return response()->json(['status'=>'ok','data'=>$proyecto],201);
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
    public function show(Request $request)
    {
        try{
            $proyectos = Proyecto::join('clientes','proyectos.cliente_id','=','clientes.id')
            ->select('proyectos.id','proyectos.nombre','proyectos.descripcion','proyectos.fecha_inicio','proyectos.fecha_fin','proyectos.estado','proyectos.cliente_id','clientes.nombre as cliente')
            ->orderBy('proyectos.id','DESC')->get();
            return $proyectos;
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
    public function update(Request $request)
    {
        try{
            $proyecto = Proyecto::findOrfail($request->id);
            $proyecto->nombre = $request->nombre;
            $proyecto->descripcion = $request->descripcion;
            $proyecto->fecha_inicio = $request->fecha_inicio;
            $proyecto->fecha_fin = $request->fecha_fin;
            $proyecto->estado = $request->estado;
            $proyecto->cliente_id = $request->cliente_id;
            if($proyecto->save()>=1){
            return response()->json(['status'=>'ok','data'=>$proyecto],202);
            }
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
    public function destroy(Request $request)
    {
        try{
            $proyecto = Proyecto::findOrfail($request->id);
            $proyecto->delete();
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

   ///para reporte parametrizado
    public function viewProyectos(){
        return view('admin.rproyectos');
    }
}
