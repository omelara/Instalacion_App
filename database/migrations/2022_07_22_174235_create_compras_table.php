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
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->integer('comprobante');
            $table->double('precio');
            $table->integer('cantidad');
            $table->integer('equipo_id')->unsigned();
            //definiendo la columna anterior como llave foranea con la tabla equipos
            $table->foreign('equipo_id')->references('id')->on('equipos');
            $table->integer('proveedor_id')->unsigned();
            //definiendo la columna anterior como llave foranea con la tabla proveedores
            $table->foreign('proveedor_id')->references('id')->on('proveedores');
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
        Schema::dropIfExists('compras');
    }
};
