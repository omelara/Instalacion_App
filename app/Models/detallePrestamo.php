<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detallePrestamo extends Model
{
    //use HasFactory;
    protected $fillable = ['prestamo_id','bodega_id'];

    public function bodegas(){
        return $this->hasMany('App\Models\Bodegas');
    }

    public function prestamos(){
        return $this->hasMany('App\Models\Prestamos');
    }

 
}
