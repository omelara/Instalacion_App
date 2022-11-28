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
        Schema::create('proyectos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',100)->unique();
            $table->string('descripcion',200)->unique();
            $table->date('fecha_inicio')->unique();
            $table->date('fecha_fin')->unique();
            $table->string('estado',20)->unique();
            $table->integer('cliente_id')->unsigned();
            //definiendo la columna anterior como llave foranea con la tabla clientes
            $table->foreign('cliente_id')->references('id')->on('clientes');
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
        Schema::dropIfExists('proyectos');
    }
};
