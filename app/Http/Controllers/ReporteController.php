<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReporteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke()
    {
        $this->middleware('welcome');
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('reporte');
    }
}
