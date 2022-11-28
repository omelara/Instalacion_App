<?php

namespace App\Http\Controllers;
use App\Models\Descargo;
use Illuminate\Http\Request;

class PDFDController extends Controller
{
    public function pdfDescargos(Request $request) {
        $fecha1 = $request->fechaInicio;
        $fecha2 = $request->fechaFinal;

        $fecha1 = date('Y-m-d',strtotime($fecha1));
        $fecha2 = date('Y-m-d',strtotime($fecha2));

        $descargos = Descargo::join('equipos', 'descargos.equipo_id', 'equipos.id')
        ->select(
            'descargos.id',
            'descargos.observacion',
            'descargos.fecha_descargo',
            'descargos.cantidad',
            'equipos.nombre as equipo',
        )
        ->whereBetween('descargos.fecha_descargo',[$fecha1,$fecha2])
        ->orderBy('descargos.id', 'DESC')->get();

        $datos = $descargos;
        $i=0;

        //convertimos la fecha al formato dia mes anio
        $fecha1 = date('d-m-Y',strtotime($fecha1));
        $fecha2 = date('d-m-Y',strtotime($fecha2));

        $pdf = \PDF::loadView('admin.descargosPDF', compact(['datos','fecha1','fecha2']));
        return $pdf->stream('descargos.pdf');
    }
}
