<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;


class ClienteController extends Controller
{
    public function index()
    {
        return view('admin.clientes');
    }

    //agregar equipos
    public function store(Request $request)
    {
        try{
            $cliente = new Cliente();
            $cliente->fecha_registro = $request->fecha_registro;
            $cliente->nombre = $request->nombre;
            $cliente->direccion = $request->direccion;
            $cliente->telefono = $request->telefono;
            $cliente->correo = $request->correo;
            $cliente->tipo_id = $request->tipo_id;
            if($cliente->save()>=1){
                return response()->json(['status'=>'ok','data'=>$cliente],201);
            }
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }


    public function show(Request $request)
    {
        try{
            $clientes = Cliente::join('tipos','clientes.tipo_id','=','tipos.id')
            ->select('clientes.id','clientes.fecha_registro','clientes.nombre','clientes.direccion','clientes.telefono','clientes.correo','clientes.tipo_id','tipos.nombre as tipo')
            ->orderBy('clientes.id','DESC')->get();
            return $clientes;
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }


    //actualizar equipo
    public function update(Request $request)
    {
        try{
            $cliente = Cliente::findOrfail($request->id);
            $cliente->fecha_registro = $request->fecha_registro;
            $cliente->nombre = $request->nombre;
            $cliente->direccion = $request->direccion;
            $cliente->telefono = $request->telefono;
            $cliente->correo = $request->correo;
            $cliente->tipo_id = $request->tipo_id;
            if($cliente->save()>=1){
                return response()->json(['status'=>'ok','data'=>$cliente],202);
            }
            $cliente->save();
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    //eliminar equipo
    public function destroy(Request $request)
    {
        try{
            $cliente = Cliente::findOrfail($request->id);
            $cliente->delete();
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
}