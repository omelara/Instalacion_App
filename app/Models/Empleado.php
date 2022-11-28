<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

 

    public function usuarios(){
        return $this->hasMany(Usuario::class,'id');
    }

    public function recursoes(){
        return $this->hasMany('App\Models\Recursoe');
    }

}
