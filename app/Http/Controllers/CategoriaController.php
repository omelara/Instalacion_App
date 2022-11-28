<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.categorias');
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
            $categoria = new Categoria();
            $categoria->nombre = $request->nombre;
            $categoria->save();
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    //actualizar categoria
    public function update(Request $request)
    {
        try{
            $categoria = Categoria::findOrfail($request->id);
            $categoria->nombre = $request->nombre;
            $categoria->save();
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    //eliminar categoria
    public function destroy(Request $request)
    {
        try{
            $categoria = Categoria::findOrfail($request->id);
            $categoria->delete();
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    //mostrar categoria
    public function show()
    {
        try{
            $categorias = Categoria::all();
            return $categorias;
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
}
