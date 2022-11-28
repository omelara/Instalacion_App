<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bodega extends Model
{
    use HasFactory;

    protected $fillable = ['cantidad','descripcion','equipo_id','marca_id','descargo_id','mantenimiento_id'];

    //relacion inversa con meididas
    public function equipo() {
        return $this->belongsTo(Equipo::class,'equipo_id');
    }

    //relacion inversa con marca
    public function marcas(){
        return $this->belongsTo('App\Models\Marca');
    }

    // 
    public function descargos(){
        return $this->hasMany(Descargos::class,'id');
    }

    public function mantenimientos(){
        return $this->hasMany(Mantenimientos::class,'id');
    }
   
}
