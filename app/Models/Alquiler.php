<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alquiler extends Model
{
    use HasFactory;

    ///compleatar la palabra
    protected $table = "alquileres";

    public function proyecto(){
        return $this->belongsTo(Proyecto::class,'proyecto_id');
    }

}
