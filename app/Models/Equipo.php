<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;


    //relacion inversa con inventarios
    public function bodegas(){
        return $this->belongsTo('App\Models\Bodega');
    }

     //relacion inversa con categorias
    public function  categorias(){
        return $this->belongsTo('App\Models\Categoria');
    }

    
}
