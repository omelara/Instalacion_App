<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;
    
    //Funcion para relacionar con la tabla empleado
    public function empleados(){
        return $this->hasMany(Empleado::class,'id');
    }
}
