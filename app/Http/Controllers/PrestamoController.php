<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Prestamo;
use App\Models\detallePrestamo;
use Error;

class PrestamoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.prestamos');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $errors = 0;
            DB::beginTransaction();
            $prestamo = new Prestamo();            
            $prestamo->correlativo = $this->getCorrelativo();
            $prestamo->fecha_prestamo = $request->fechaPrestamo;
            $prestamo->fecha_devuelto = $request->fechaDevuelto;
            //$prestamo->proyecto_origen = $request->proyectoOrigen;
            //$prestamo->proyecto_destino = $request->proyectoDestino;
            $prestamo->estado = "R";
            $prestamo->user_id = $request->user['id'];
            if ($prestamo->save()<=0) {
                $errors++;
            }
            $detalle = $request->bodegas;
            foreach ($detalle as $key => $det) {
                //Creamos el objeto de tipo DetallePrestamo
                $detPrestamo= new detallePrestamo();
                $detPrestamo->bodega_id = $det['bodega']['id'];
                $detPrestamo->prestamo_id = $prestamo->id;
                //guardamos en la tabla detalle_prestamos
                if ($detPrestamo->save()<=0) {
                    $errors++;
                }
            }
            if ($errors == 0) {
                DB::commit();
                return response()->json(['status'=>'ok','data'=>$prestamo],201);
            }
            else {
                DB::rollBack();
                return response()->json(['status'=>'fail','data'=>$prestamo],209);
            }
        }
        catch(\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

      //Metodo para cambiar el estado del prestamo
    public function changeState(Request $request) {
        try {
            $prestamo = Prestamo::findOrFail($request->id);
            $prestamo->estado = $request->estado;
            $prestamo->save();
        }catch(\Exception $e) {
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
        $state = $request->state;   
        $prestamos = Prestamo::join('users','prestamos.user_id','=','users.id')
            ->select('prestamos.id','prestamos.correlativo','prestamos.fecha_prestamo','prestamos.fecha_devuelto',
            /*'prestamos.proyecto_origen','prestamos.proyecto_destino'*/'prestamos.estado','users.name')
            ->where('prestamos.estado','=',$state)
            ->orderBy('prestamos.id','desc')->get();
        return $prestamos;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //Metodo para generear el correlativo de prestamo
    public function getCorrelativo() {
        $result = DB::select("SELECT CONCAT(TRIM(YEAR(CURDATE())),LPAD(TRIM(MONTH(CURDATE())),2,0),LPAD(IFNULL(MAX(TRIM(SUBSTRING(correlativo,7,4))),0)+1,4,0)) as correlativo FROM prestamos WHERE SUBSTRING(correlativo,1,6) = CONCAT(TRIM(YEAR(CURDATE())),LPAD(TRIM(MONTH(CURDATE())),2,0))");
        return $result[0]->correlativo;
    }

    ///para reporte parametrizado
    public function viewPrestamos(){
        return view('admin.rprestamos');
    }

    //agrgado actualenye
    public function viewByUser(){
        return view('reservas');
    }
    public function getByUser($id){
        $reservas = Prestamo::join('users','prestamos.user_id','=','users.id')
        ->select('prestamos.id','prestamos.correlativo','prestamos.fecha_prestamo','prestamos.fecha_devuelto',
        /*'prestamos.proyecto_origen','prestamos.proyecto_destino'*/'prestamos.estado','users.name')
        ->where('prestamos.estado','=', 'R')
        ->where('prestamos.user_id','=',$id)
        ->orderBy('prestamos.id','desc')->get();
        return $reservas;
    }

    public function getAll(){
        $prestamos = Prestamo::all();
        dd($prestamos);
    }
}
