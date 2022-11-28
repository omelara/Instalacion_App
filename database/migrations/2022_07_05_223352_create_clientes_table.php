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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_registro')->unique();
            $table->string('nombre',200)->unique();
            $table->string('direccion',200)->unique();
            $table->string('telefono',10)->unique();
            $table->string('correo',200)->unique();
            $table->integer('tipo_id')->unsigned();
            //definiendo la columna anterior como llave foranea con la tabla tipos
            $table->foreign('tipo_id')->references('id')->on('tipos');
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
        Schema::dropIfExists('clientes');
    }
};
