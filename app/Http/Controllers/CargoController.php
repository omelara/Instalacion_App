<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use Illuminate\Http\Request;

class CargoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.cargos');
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
            $cargo = new Cargo();
            $cargo->nombre = $request->nombre;
            $cargo->save();
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    //actualizar categoria
    public function update(Request $request)
    {
        try{
            $cargo = Cargo::findOrfail($request->id);
            $cargo->nombre = $request->nombre;
            $cargo->save();
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    //eliminar categoria
    public function destroy(Request $request)
    {
        try{
            $cargo = Cargo::findOrfail($request->id);
            $cargo->delete();
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    //mostrar categoria
    public function show()
    {
        try{
            $cargos = Cargo::all();
            return $cargos;
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
}
