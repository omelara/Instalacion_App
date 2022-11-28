<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipo;

class EquipoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.equipos');
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
            $equipo = new Equipo();
            $equipo->nombre = $request->nombre;
            $equipo->categoria_id = $request->categoria_id;
            if($equipo->save()>=1){
            return response()->json(['status'=>'ok','data'=>$equipo],201);
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
            $equipos = Equipo::join('categorias','equipos.categoria_id','=','categorias.id')
            ->select('equipos.id','equipos.nombre','equipos.categoria_id','categorias.nombre as categoria')
            ->orderBy('equipos.id','DESC')->get();
            return $equipos;
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
            $equipo = Equipo::findOrfail($request->id);
            $equipo->nombre = $request->nombre;
            $equipo->categoria_id = $request->categoria_id;
            $equipo->save();
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
            $equipo = Equipo::findOrfail($request->id);
            $equipo->delete();
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
}
