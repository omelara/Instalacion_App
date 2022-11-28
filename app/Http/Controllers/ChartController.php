<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prestamo;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function index(){

        $prestamos = Prestamo::select(DB::raw("COUNT(*) as count"))
            ->whereYear('fecha_prestamo',date('Y'))
            ->groupBy(DB::raw("Month(fecha_prestamo)"))
            ->pluck('count');

        $months = Prestamo::select(DB::raw("Month(fecha_prestamo) as month"))
            ->whereYear('fecha_prestamo', date('Y'))

            ->groupBy(DB::raw("Month(fecha_prestamo)"))
            ->pluck('month');
        
        $datas = array(0,0,0,0,0,0,0,0,0,0,0,0);
        //llenando los prestamos en el arreglo datas
        foreach($months as $index => $month){
            $datas[$month-1] = $prestamos[$index];
        }
        return view('admin.chart', compact('datas'));

    }

    public function bars(){
        return view("Grafico de lineas");
    }
    
}