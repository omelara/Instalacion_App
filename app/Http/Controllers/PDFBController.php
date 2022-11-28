<?php

namespace App\Http\Controllers;

use App\Models\Bodega;
use Illuminate\Http\Request;

class PDFBController extends Controller
{
    public function pdfBodegas() {
        $bodegas = Bodega::join('equipos', 'bodegas.equipo_id', 'equipos.id')
        ->join('marcas', 'bodegas.marca_id', 'marcas.id')
        ->select(
            'bodegas.id',
            'bodegas.cantidad',
            'bodegas.descripcion',
            'bodegas.codigo',
            'equipos.nombre as equipo',
            'marcas.nombre as marca',
        )
        ->orderBy('bodegas.id', 'DESC')->get();

        $pdf = \PDF::loadView("admin.listBodegasPDF", compact('bodegas'));
        return $pdf->stream('bodegas.pdf');
    }

    /*
    public function pdfPrestamos( Request $request ){
        $fecha1 = $request->fechaInicio;
        $fecha2 = $request->fechaFinal;
        
        $prestamos = Prestamo::join('users','prestamos.user_id','=','users.id')
        ->select('prestamos.id','prestamos.correlativo','prestamos.fecha_prestamo','prestamos.fecha_devuelto',
        'prestamos.estado',
        'users.name')
        ->where('prestamos.estado','=','D')
        ->whereBetween('fecha_prestamo',[$fecha1,$fecha2])
        ->orderBy('prestamos.id','desc')->get();

        $pdf = \PDF::loadView("admin.prestamosPDF", compact('prestamos'));
        return $pdf->stream('prestamos.pdf');

        $datos = $prestamos;
        $i=0;
        foreach($prestamos as $p){
            $detalle_p = Prestamo::join('detalle_prestamos','detalle_prestamos.prestamo_id','prestamos.id')
            ->join('bodegas','detalle_prestamos.bodega_id','bodegas.id')
            ->join('marcas','bodegas.marca_id','marcas.id')
            ->select(
                'bodegas.cantidad','bodegas.descripcion','bodegas.codigo','marcas.nombre as marca'
            )
            ->where('detalle_prestamos.prestamo_id','=',$p->id)->get();
            $datos[$i]["detalle"] = $detalle_p;
            $i++;
        }
        $fecha1 = date('d-m-Y',strtotime($fecha1));
        $fecha2 = date('d-m-Y',strtotime($fecha2));

        //$fechas = ["f1"=>$fecha1,"f2"=>$fecha2];

        $pdf = \PDF::loadView('admin.prestamosPDF',compact(['datos','fecha1','fecha2']));
        return $pdf->stream('prestamos.pdf');
    }*/
}
