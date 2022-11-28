<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compra;

class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.compras');
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
            $compra = new Compra();
            $compra->fecha = $request->fecha;
            $compra->comprobante = $request->comprobante;
            $compra->precio = $request->precio;
            $compra->cantidad = $request->cantidad;
            $compra->equipo_id = $request->equipo_id;
            $compra->proveedor_id = $request->proveedor_id;
            if($compra->save()>=1){
              return response()->json(['status'=>'ok','data'=>$compra],201);
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
            $compras = Compra::join('proveedores','compras.proveedor_id','=','proveedores.id')
            ->join('equipos','compras.equipo_id','=','equipos.id')
            ->select('compras.id','compras.fecha','compras.comprobante','compras.precio','compras.cantidad','compras.equipo_id','equipos.nombre as equipo','compras.proveedor_id','proveedores.nombre as proveedor')
            ->orderBy('compras.id','DESC')->get();
            return $compras;
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
            $compra = Compra::findOrfail($request->id);
            $compra->fecha = $request->fecha;
            $compra->comprobante = $request->comprobante;
            $compra->precio = $request->precio;
            $compra->cantidad = $request->cantidad;
            $compra->equipo_id = $request->equipo_id;
            $compra->proveedor_id = $request->proveedor_id;
            $compra->save();
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
            $compra = Compra::findOrfail($request->id);
            $compra->delete();
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    
       ///retornamos la vista en admin para reporte parametrizado
       public function viewCompras(){
        return view('admin.rcompras');
    }
}
