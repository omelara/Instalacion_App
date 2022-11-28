<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
  
    use HasFactory;
    


    public function clientes(){
        return $this->belongsTo('App\Models\Cliente');
    }

    public function grupos(){
       return $this->hasMany(Grupo::class,'id');
    }

    public function prestamos(){
        return $this->hasMany(Prestamo::class,'id');
    }

    public function alquileres(){
        return $this->belongsTo('App\Models\Alquiler');
    }

    public function asignaciones(){
      return $this->hasMany(Asignacion::class,'id');
    }
}
