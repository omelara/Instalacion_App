<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('descargos', function (Blueprint $table) {
            $table->id();
            $table->string('observacion',100)->unique();
            $table->date('fecha_descargo');
            $table->integer('cantidad');
            $table->integer('equipo_id')->unsigned();
            //definiendo la columna anterior como llave foranea con la tabla categorias
            $table->foreign('equipo_id')->references('id')->on('equipos');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('descargos');
    }
};
