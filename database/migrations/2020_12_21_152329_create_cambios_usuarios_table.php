<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCambiosUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cambios_usuarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('usuario_antiguo');
            $table->unsignedBigInteger('usuario_actual');
            $table->unsignedBigInteger('usuario_modificador');
            $table->string('observacion',50)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('usuario_antiguo')->references('id')->on('users');
            $table->foreign('usuario_actual')->references('id')->on('users');
            $table->foreign('usuario_modificador')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cambios_usuarios');
    }
}
