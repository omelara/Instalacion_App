<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = "clientes";

    public function proyectos(){
        return $this->hasMany(Proyecto::class,'id');
    }

    public function tipos() {
        return $this->belongsTo(Tipo::class,'tipo_id');
    }
}
