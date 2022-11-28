<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    protected $fillable = ['nombre'];

    public function clientes(){
        return $this->hasMany('App\Models\Cliente');
    }
}
