<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo',12);
            $table->string('name',80);
            $table->string('email',191)->unique()->nullable();
            $table->string('email_old',191)->nullable();
            $table->string('telefono',15)->nullable();
            $table->tinyInteger('activo')->default(1);
            $table->unsignedInteger('tipo_usuario');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('tipo_usuario')->references('id')->on('tipos_usuario');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
