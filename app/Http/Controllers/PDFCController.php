<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class PDFCController extends Controller
{
    public function pdfClientes() 
    {
        $clientes = Cliente::join('tipos', 'clientes.tipo_id', 'tipos.id')
        ->select(
            'clientes.id',
            'clientes.fecha_registro',
            'clientes.nombre',
            'clientes.direccion',
            'clientes.telefono',
            'clientes.correo',
            'tipos.nombre as tipo',
        )
        ->orderBy('clientes.id', 'DESC')->get();
        

        $pdf = \PDF::loadView("admin.listClientesPDF", compact('clientes'));
        return $pdf->stream('clientes.pdf');
    }
}
