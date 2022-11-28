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
        Schema::create('bodegas', function (Blueprint $table) {
            $table->id();
            $table->integer('cantidad');
            $table->string('descripcion',100);
            $table->string('codigo',10)->unique();
            //
            $table->integer('equipo_id')->unsigned();
            //definiendo la columna anterior como llave foranea con la tabla equipos
            $table->foreign('equipo_id')->references('id')->on('equipos');
            //
            $table->integer('marca_id')->unsigned();
            //definiendo la columna anterior como llave foranea con la tabla marcas
            $table->foreign('marca_id')->references('id')->on('marcas');
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
        Schema::dropIfExists('bodegas');
    }
};
