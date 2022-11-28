<?php

namespace App\Http\Controllers;
use App\Models\Descargo;
use Illuminate\Http\Request;

class DescargoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.descargos');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $descargo = new Descargo();
            $descargo->observacion = $request->observacion;
            $descargo->fecha_descargo = $request->fecha_descargo;
            $descargo->cantidad = $request->cantidad;
            $descargo->equipo_id = $request->equipo_id;
            if($descargo->save()>=1){
            return response()->json(['status'=>'ok','data'=>$descargo],201);
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
            $descargos = Descargo::join('equipos','descargos.equipo_id','=','equipos.id')
            ->select('descargos.id','descargos.observacion','descargos.fecha_descargo','descargos.cantidad','descargos.equipo_id','equipos.nombre as equipo')
            ->orderBy('descargos.id','DESC')->get();
            return $descargos;
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
            $descargo = Descargo::findOrfail($request->id);
            $descargo->observacion = $request->observacion;
            $descargo->fecha_descargo = $request->fecha_descargo;
            $descargo->cantidad = $request->cantidad;
            $descargo->equipo_id = $request->equipo_id;
            $descargo->save();
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
            $descargo = Descargo::findOrfail($request->id);
            $descargo ->delete();
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

       ///retornamos la vista en admin para reporte parametrizado
       public function viewDescargos(){
        return view('admin.rdescargos');
    }

}
