<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubCategoriaDocumentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_categoria_documentos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');

            $table->unsignedBigInteger('categoria_documento_id');
            $table->foreign('categoria_documento_id')->references('id')->on('categoria_documentos');

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
        Schema::dropIfExists('sub_categoria_documentos');
    }
}
