<?php

namespace App\Http\Controllers;

use App\Models\Asignacion;
use Illuminate\Http\Request;

class PDFASController extends Controller
{
    public function pdfAsignaciones() {
        $asignaciones = Asignacion::join('equipos', 'asignaciones.equipo_id', 'equipos.id')
        ->join('proyectos', 'asignaciones.proyecto_id', 'proyectos.id')
        ->select(
            'asignaciones.id',
            'asignaciones.presupuesto_i',
            'asignaciones.cantidad',
            'asignaciones.fecha',
            'equipos.nombre as equipo',
            'proyectos.nombre as proyecto',
            'asignaciones.gasto_f',
        )
        ->orderBy('asignaciones.id', 'DESC')->get();

        $pdf = \PDF::loadView("admin.listAsignacionesPDF", compact('asignaciones'));
        return $pdf->stream('asignaciones.pdf');
    }
}
