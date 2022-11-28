<?php

namespace App\Http\Controllers;

use App\Models\Mantenimiento;
use Illuminate\Http\Request;

class PDFMController extends Controller
{
    public function pdfMantenimientos(Request $request) {
        $fecha1 = $request->fechaInicio;
        $fecha2 = $request->fechaFinal;

        $fecha1 = date('Y-m-d',strtotime($fecha1));
        $fecha2 = date('Y-m-d',strtotime($fecha2));

        $mantenimientos = Mantenimiento::join('equipos', 'mantenimientos.equipo_id', 'equipos.id')
        ->select(
            'mantenimientos.id',
            'mantenimientos.observacion',
            'mantenimientos.fecha',
            'mantenimientos.encargado',
            'equipos.nombre as equipo',
        )
        ->whereBetween('mantenimientos.fecha',[$fecha1,$fecha2])
        ->orderBy('mantenimientos.id', 'DESC')->get();

        $datos = $mantenimientos;
        $i=0;

                //convertimos la fecha al formato dia mes anio
        $fecha1 = date('d-m-Y',strtotime($fecha1));
        $fecha2 = date('d-m-Y',strtotime($fecha2));

        $pdf = \PDF::loadView("admin.mantenimientosPDF", compact(['datos','fecha1','fecha2']));
        return $pdf->stream('mantenimientos.pdf');
    }
}
