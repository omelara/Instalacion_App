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
        Schema::create('recursoes', function (Blueprint $table) {
            $table->id();
            $table->string('equipo',90)->unique();
            $table->integer('cantidad');
            $table->integer('empleado_id')->unsigned();
            //definiendo la columna anterior como llave foranea con la tabla empleados
            $table->foreign('empleado_id')->references('id')->on('empleados');
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
        Schema::dropIfExists('recursoes');
    }
};
