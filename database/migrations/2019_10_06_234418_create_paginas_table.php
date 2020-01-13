<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaginasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paginas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre')->nullable()->default(null);
            $table->longText('contenido')->nullable()->default(null);
            $table->text('mensaje_uno')->nullable()->default(null);
            $table->text('mensaje_dos')->nullable()->default(null);
            $table->string('video_url')->nullable()->default(null);
            $table->string('video_titulo')->nullable()->default('Sin vídeo.');
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
        Schema::dropIfExists('paginas');
    }
}
