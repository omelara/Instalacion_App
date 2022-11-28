<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use Illuminate\Http\Request;

class PDFGController extends Controller
{
    public function pdfGrupos() {
        $grupos = Grupo::join('cargos', 'grupos.cargo_id', 'cargos.id')
        ->join('empleados', 'grupos.empleado_id', 'empleados.id')
        ->join('proyectos', 'grupos.proyecto_id', 'proyectos.id')
        ->select(
            'grupos.id',
            'grupos.fecha',
            'cargos.nombre as cargo',
            'empleados.nombre as empleado',
            'proyectos.nombre as proyecto',
        )
        ->orderBy('grupos.id', 'DESC')->get();

        $pdf = \PDF::loadView("admin.listGruposPDF", compact('grupos'));
        return $pdf->stream('grupos.pdf');
    }
}
