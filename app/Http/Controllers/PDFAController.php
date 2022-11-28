<?php

namespace App\Http\Controllers;

use App\Models\Alquiler;
use Illuminate\Http\Request;

class PDFAController extends Controller
{
    public function pdfAlquileres(Request $request ){
        $fecha1 = $request->fechaInicio;
        $fecha2 = $request->fechaFinal;

        $alquileres = Alquiler::join('proyectos','alquileres.proyecto_id','=','proyectos.id')
        ->select('alquileres.id',
         'alquileres.equipo',
         'alquileres.cantidad',
         'alquileres.fecha',
         'alquileres.fecha_devuelto',
         'alquileres.propietario',
         'proyectos.nombre as proyecto',)
        ->whereBetween([$fecha1,$fecha2])
        ->orderBy('alquileres.id','DESC')->get();


        $datos = $alquileres;
        $i=0;
        foreach($alquileres as $a){
            $detalle_a = Alquiler::join('detalle_alquileres','detalle_alquileres.alquiler_id','alquileres.id')
            ->join('proyectos','detalle_alquileres.proyecto_id','proyectos.id')
            ->select(
                'alquileres.equipo','alquileres.cantidad','alquileres.fecha','fecha_devuelto','propietario','proyectos.nombre as proyecto'
            )
            ->where('detalle_alquileres.alquiler_id','=',$a->id)->get();
            $datos[$i]["detalle"] = $detalle_a;
            $i++;
        }
        $fecha1 = date('d-m-Y',strtotime($fecha1));
        $fecha2 = date('d-m-Y',strtotime($fecha2));

       // $fechas = ["f1"=>$fecha1,"f2"=>$fecha2];

        $pdf = \PDF::loadView('admin.alquileresPDF',compact(['datos','fecha1','fecha2']));
        return $pdf->stream('alquileres.pdf');
    } 

}
