<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    public function index()
    {
        return view('admin.marcas');
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
            $marca = new Marca();
            $marca->nombre = $request->nombre;
            $marca->save();
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    //actualizar categoria
    public function update(Request $request)
    {
        try{
            $marca = Marca::findOrfail($request->id);
            $marca->nombre = $request->nombre;
            $marca->save();
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    //eliminar categoria
    public function destroy(Request $request)
    {
        try{
            $marca = Marca::findOrfail($request->id);
            $marca->delete();
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    //mostrar categoria
    public function show()
    {
        try{
            $marcas = Marca::orderBy('id','DESC')->get();
            return $marcas;
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
}