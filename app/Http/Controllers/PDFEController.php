<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

class PDFEController extends Controller
{
    public function pdfEmpleados() {
        $empleados = Empleado::
        select(
            'empleados.id',
            'empleados.fecha_registro',
            'empleados.nombre',
            'empleados.fecha_nacimiento',
            'empleados.telefono',
            'empleados.correo',
            'empleados.salario',
        )
        ->orderBy('empleados.id', 'DESC')->get();
        

        $pdf = \PDF::loadView("admin.listEmpleadosPDF", compact('empleados'));
        return $pdf->stream('empleados.pdf');
    }
}
