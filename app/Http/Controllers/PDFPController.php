<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Illuminate\Http\Request;

class PDFPController extends Controller
{
    public function pdfProyectos(Request $request) {
        $fecha1 = $request->fechaInicio;
        $fecha2 = $request->fechaFinal;

        $fecha1 = date('Y-m-d',strtotime($fecha1));
        $fecha2 = date('Y-m-d',strtotime($fecha2));

        $proyectos = Proyecto::join('clientes', 'proyectos.cliente_id', 'clientes.id')
        ->select(
            'proyectos.id',
            'proyectos.nombre',
            'proyectos.descripcion',
            'proyectos.fecha_inicio',
            'proyectos.fecha_fin',
            'proyectos.estado',
            'clientes.nombre as cliente'
        )
        ->whereBetween('proyectos.fecha_inicio',[$fecha1,$fecha2])
        ->orderBy('proyectos.id', 'DESC')->get();

        $datos = $proyectos;
        $i=0;

        //convertimos la fecha al formato dia mes anio
        $fecha1 = date('d-m-Y',strtotime($fecha1));
        $fecha2 = date('d-m-Y',strtotime($fecha2));

        $pdf = \PDF::loadView('admin.proyectosPDF',compact(['datos','fecha1','fecha2']));
        return $pdf->stream('proyectos.pdf');
    }
}
