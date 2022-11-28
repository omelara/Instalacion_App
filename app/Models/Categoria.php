<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;


    //relacion inversa con equipo
    public function equipos(){
        return $this->belongsTo('App\Models\Equipo');
    }
}
