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
        Schema::create('asignaciones', function (Blueprint $table) {
            $table->id();
            $table->double('presupuesto_i');
            $table->double('gasto_f'); 
            $table->integer('cantidad');
            $table->date('fecha');                     //
            $table->integer('equipo_id')->unsigned();
            //definiendo la columna anterior como llave foranea con la tabla equipos
            $table->foreign('equipo_id')->references('id')->on('equipos');
            //
            $table->integer('proyecto_id')->unsigned();
            //definiendo la columna anterior como llave foranea con la tabla proyectos
            $table->foreign('proyecto_id')->references('id')->on('proyectos');
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
        Schema::dropIfExists('asignaciones');
    }
};
