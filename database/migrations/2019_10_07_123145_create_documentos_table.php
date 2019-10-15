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
            $table->string('codigo_interno')->nullable()->default('');
            $table->string('documento_url')->nullable()->default('');
            $table->integer('valor')->default(0);
            $table->integer('clasificacion')->default(0);
            $table->integer('cantidad_descargas')->nullable()->default(0);
            $table->string('extension')->nullable()->default('');
            $table->integer('version')->default('1');

            $table->unsignedInteger('categoria_documentos_id');
            $table->foreign('categoria_documentos_id')->references('id')->on('categoria_documentos');
    
            $table->integer('estado')->default(0);

            $table->unsignedInteger('user_id');
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
