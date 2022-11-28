<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bodega;

class BodegaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.bodegas');
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
            $bodega = new Bodega();
            $bodega->cantidad = $request->cantidad;
            $bodega->descripcion = $request->descripcion;
            $bodega->codigo = $request->codigo;
            $bodega->equipo_id = $request->equipo_id;
            $bodega->marca_id = $request->marca_id;
            if($bodega->save()>=1){
            return response()->json(['status'=>'ok','data'=>$bodega],201);
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
            $bodegas = Bodega::join('equipos','bodegas.equipo_id','=','equipos.id')
            ->join('marcas','bodegas.marca_id','=','marcas.id')
            ->select('bodegas.id','bodegas.cantidad','bodegas.descripcion','bodegas.codigo','bodegas.equipo_id','equipos.nombre as equipo','bodegas.marca_id','marcas.nombre as marca')
            ->orderBy('bodegas.id','DESC')->get();
            return $bodegas;
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
            $bodega = Bodega::findOrfail($request->id);
            $bodega->cantidad = $request->cantidad;
            $bodega->descripcion = $request->descripcion;
            $bodega->codigo = $request->codigo;
            $bodega->equipo_id = $request->equipo_id;
            $bodega->marca_id = $request->marca_id;
            if($bodega->save()>=1){
            return response()->json(['status'=>'ok','data'=>$bodega],202);
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
            $bodega = Bodega::findOrfail($request->id);
            $bodega->delete();
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
}
