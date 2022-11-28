<?php

namespace App\Http\Controllers;

use App\Models\Recursoe;
use Illuminate\Http\Request;

class RecursoeController extends Controller
{
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.recursoes');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //print($request); 
        try{
            $recursoe = new Recursoe();
            $recursoe->equipo = $request->equipo;
            $recursoe->cantidad = $request->cantidad;
            $recursoe->empleado_id = $request->empleado_id;
            if($recursoe->save()>=1){
            return response()->json(['status'=>'ok','data'=>$recursoe],201);
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
            $recursoes = Recursoe::join('empleados','recursoes.empleado_id','=','empleados.id')
            ->select('recursoes.id','recursoes.equipo','recursoes.cantidad','recursoes.empleado_id','empleados.nombre as empleado')
            ->orderBy('recursoes.id','DESC')->get();
            return $recursoes;
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
            $recursoe = Recursoe::findOrfail($request->id);
            $recursoe->equipo = $request->equipo;
            $recursoe->cantidad = $request->cantidad;
            $recursoe->empleado_id = $request->empleado_id;
            if($recursoe->save()>=1){
            return response()->json(['status'=>'ok','data'=>$recursoe],202);
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
            $recursoe = Recursoe::findOrfail($request->id);
            $recursoe->delete();
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
}
