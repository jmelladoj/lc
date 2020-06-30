<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvitacionUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invitacion_usuarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('correo_invitado');
            $table->smallInteger('pagada')->nullable()->default(0);
            $table->smallInteger('inicio_sesion')->nullable()->default(0);
            $table->integer('recompensa')->nullable()->default(250);

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('invitacion_usuarios');
    }
}
