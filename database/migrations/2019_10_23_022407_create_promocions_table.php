<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromocionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promociones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titulo');
            $table->string('fecha');
            $table->integer('tipo_persona');

            $table->string('url_imagen')->nullable()->default(null);

            $table->unsignedBigInteger('categorias_usuarios_id')->nullable()->default(null);
            $table->foreign('categorias_usuarios_id')->references('id')->on('categoria_usuarios');
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
        Schema::dropIfExists('promociones');
    }
}
