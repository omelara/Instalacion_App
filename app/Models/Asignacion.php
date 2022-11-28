<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignacion extends Model
{
    protected $table = "asignaciones";
    use HasFactory;

    //relacion inversa con bodegas
    public function equipos(){
        return $this->belongsTo('App\Models\Equipo');
    }

    //relacion inversa con proveedores
    public function proyectos(){
        return $this->belongsTo('App\Models\Proyecto');
    }
    
}
