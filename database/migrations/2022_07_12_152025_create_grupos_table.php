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
        Schema::create('grupos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->integer('cargo_id')->unsigned()->unique();
            //definiendo la columna anterior como llave foranea con la tabla cargos
            $table->foreign('cargo_id')->references('id')->on('cargos');

            $table->integer('empleado_id')->unsigned()->unique();
            //definiendo la columna anterior como llave foranea con la tabla empleados
            $table->foreign('empleado_id')->references('id')->on('empleados');

            $table->integer('proyecto_id')->unsigned()->unique();
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
        Schema::dropIfExists('grupos');
    }
};
