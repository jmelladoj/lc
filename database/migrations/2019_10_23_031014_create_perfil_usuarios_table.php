<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerfilUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perfil_usuarios', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('nombre_fantasia')->nullable()->default(null);
            $table->string('fecha_nacimiento');
            $table->integer('telefono');
            $table->string('domicilio');

            $table->unsignedBigInteger('comuna_id');
            $table->foreign('comuna_id')->references('id')->on('comunas');

            $table->string('estado_civil')->nullable()->default(null);
            $table->boolean('hijos')->nullable()->default(false);
            $table->integer('cantidad_hijos')->default(0);


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
        Schema::dropIfExists('perfil_usuarios');
    }
}
