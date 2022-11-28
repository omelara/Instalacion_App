<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function pdfCompras(Request $request) {

        $fecha1 = $request->fechaInicio;
        $fecha2 = $request->fechaFinal;

        $fecha1 = date('Y-m-d',strtotime($fecha1));
        $fecha2 = date('Y-m-d',strtotime($fecha2));

        $compras = Compra::join('proveedores', 'compras.proveedor_id', 'proveedores.id')
        ->join('equipos', 'compras.equipo_id', 'equipos.id')
        ->select(
            'compras.id',
            'compras.fecha',
            'compras.comprobante',
            'compras.precio',
            'compras.cantidad',
            'equipos.nombre as equipo',
            'proveedores.nombre as proveedor',
        )
        ->whereBetween('compras.fecha',[$fecha1,$fecha2])
        ->orderBy('compras.id', 'DESC')->get();
        
        $datos = $compras;
        $i=0;

        //convertimos la fecha al formato dia mes anio
        $fecha1 = date('d-m-Y',strtotime($fecha1));
        $fecha2 = date('d-m-Y',strtotime($fecha2));

        $pdf = \PDF::loadView("admin.comprasPDF", compact(['datos','fecha1','fecha2']));
        return $pdf->stream('compras.pdf');     
    }


}
