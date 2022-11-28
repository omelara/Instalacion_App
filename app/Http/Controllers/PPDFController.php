<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Prestamo;

class PPDFController extends Controller
{
    public function pdfPrestamos(Request $request ){
        $fecha1 = $request->fechaInicio;
        $fecha2 = $request->fechaFinal;

        $fecha1 = date('Y-m-d',strtotime($fecha1));
        $fecha2 = date('Y-m-d',strtotime($fecha2));

        $prestamos = Prestamo::join('users','prestamos.user_id','=','users.id')
        ->select('prestamos.id','prestamos.correlativo',
         'prestamos.fecha_prestamo',
         'prestamos.fecha_devuelto',
         'users.name')
        ->where('prestamos.estado','=','D')
        ->whereBetween('prestamos.fecha_prestamo',[$fecha1,$fecha2])
        ->orderBy('prestamos.id','DESC')->get();

        
        $datos = $prestamos;
        $i=0;
        foreach($prestamos as $p){
            $detalle_p = Prestamo::join('detalle_prestamos','detalle_prestamos.prestamo_id','prestamos.id')
            ->join('bodegas','detalle_prestamos.bodega_id','bodegas.id')
            ->join('equipos','bodegas.equipo_id','equipos.id')
            ->join('marcas','bodegas.marca_id','marcas.id')
            ->select(
                'bodegas.codigo','equipos.nombre as equipo','bodegas.descripcion','marcas.nombre as marca'
            )
            ->where('detalle_prestamos.prestamo_id','=',$p->id)->get();
            $datos[$i]["detalle"] = $detalle_p;
            $i++;
        }
        //convertimos la fecha al formato dia mes anio
        $fecha1 = date('d-m-Y',strtotime($fecha1));
        $fecha2 = date('d-m-Y',strtotime($fecha2));

       // $fechas = ["f1"=>$fecha1,"f2"=>$fecha2];

        $pdf = \PDF::loadView('admin.prestamosPDF',compact(['datos','fecha1','fecha2']));
        return $pdf->stream('prestamos.pdf'); 
    } 
}
