<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;
    

    //Relacion de 1:N con Compra
    public function equipos(){
        return $this->belongsTo(Equipo::class,'id');
    }

    //relacion inversa con proveedor
    public function proveedores(){
        return $this->belongsTo('App\Models\Proveedor');
    }
}
