<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
   //protected $fillable = ['correlativo','fecha_compra','estado','user_id'];


   public function user() {
    return $this->belongsTo(User::class,'user_id');
}

public function detallePrestamo() {
    return $this->hasMany(detallePrestamo::class,'id');
}
}
