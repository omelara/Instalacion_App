<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alquiler;
use App\Models\detalleAlquiler;

class AlquilerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.alquileres');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $alquiler = new Alquiler();
            $alquiler->equipo = $request->equipo;
            $alquiler->cantidad = $request->cantidad;
            $alquiler->fecha = $request->fecha;
            $alquiler->fecha_devuelto = $request->fecha_devuelto;
            $alquiler->propietario = $request->propietario;
            $alquiler->proyecto_id = $request->proyecto_id;
            if($alquiler->save()>=1){
            return response()->json(['status'=>'ok','data'=>$alquiler],201);
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
            $alquileres = Alquiler::join('proyectos','alquileres.proyecto_id','=','proyectos.id')
            ->select('alquileres.id','alquileres.equipo','alquileres.cantidad','alquileres.fecha','alquileres.fecha_devuelto','alquileres.propietario','alquileres.proyecto_id','proyectos.nombre as proyecto')
            ->orderBy('alquileres.id','DESC')->get();
            return $alquileres;
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
            $alquiler = Alquiler::findOrfail($request->id);
            $alquiler->equipo = $request->equipo;
            $alquiler->cantidad = $request->cantidad;
            $alquiler->fecha = $request->fecha;
            $alquiler->fecha_devuelto = $request->fecha_devuelto;
            $alquiler->propietario = $request->propietario;
            $alquiler->proyecto_id = $request->proyecto_id;
              $alquiler->save();
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
            $alquiler = Alquiler::findOrfail($request->id);
            $alquiler->delete();
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

        ///para reporte parametrizado
        public function viewAlquileres(){
            return view('admin.ralquileres');
        }
}
