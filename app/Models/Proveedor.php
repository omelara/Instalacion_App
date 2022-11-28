<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = "proveedores";
    protected $fillable = ['nombre'];

    public function bodegas(){
        return $this->hasMany('App\Models\Bodegas');
    }
}
