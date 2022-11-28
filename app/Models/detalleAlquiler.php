<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detalleAlquiler extends Model
{
    use HasFactory;
    public function alquiler(){
        return $this->belongsTo(Alquiler::class,'alquiler_id');
    }
}
