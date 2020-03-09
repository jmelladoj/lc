<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titulo');
            $table->text('descripcion');
            $table->string('codigo')->nullable()->default('');
            $table->string('documento_url')->nullable()->default('');
            $table->integer('valor')->nullable()->default(0);
            $table->integer('cantidad_descargas')->nullable()->default(0);
            $table->string('extension')->nullable()->default('');
            $table->integer('version')->default('1');
            $table->integer('seccion_nuevo')->default(0);
            $table->integer('seccion_descargados')->default(0);
            $table->string('url_imagen_vista_uno')->nullable()->default(null);
            $table->string('url_imagen_vista_dos')->nullable()->default(null);

            $table->unsignedBigInteger('categorias_documentos_id')->nullable()->default(null);
            $table->foreign('categorias_documentos_id')->references('id')->on('categoria_documentos');

            $table->integer('estado')->default(0);

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->softDeletes();
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
        Schema::dropIfExists('documentos');
    }
}
