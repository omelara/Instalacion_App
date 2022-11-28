<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mantenimiento extends Model
{

    public function equipos(){
        return $this->hasMany(Equipo::class,'id');
    }
}