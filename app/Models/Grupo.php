<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;
    //protected $table = 'grupos';

    //protected $fillable = ['cargo_id','empleado_id','proyecto_id',];

    //con relacion inversa con marca
    public function cargo(){
        return $this->belongsTo(Cargo::class,'cargo_id');
    }

    //con relacion inversa con prestamo
    public function empleado(){
        return $this->belongsTo(Empleado::class,'empleado_id');
    }

    //con relacion inversa con prestamo
    public function proyecto(){
        return $this->belongsTo(proyecto::class,'proyecto_id');
    }

    
}
