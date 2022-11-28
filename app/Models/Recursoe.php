<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recursoe extends Model
{
    protected $table = "recursoes";
   // use HasFactory;
    
   public function empleados(){
        return $this->belongsTo('App\Models\Empleado');
    }

}
