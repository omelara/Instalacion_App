<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Descargo extends Model
{
    use HasFactory;

    //relacion inversa con alquileres
    public function equipo() {
        return $this->belongsTo(Equipo::class,'equipo_id');
    }
    
}    
