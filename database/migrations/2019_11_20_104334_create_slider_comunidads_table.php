<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSliderComunidadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slider_comunidades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('texto');
            $table->string('color');
            $table->string('subtexto')->nullable()->default(null);
            $table->string('subcolor')->nullable()->default(null);
            $table->string('texto_boton');
            $table->string('texto_modal');
            $table->string('texto_alerta');
            $table->string('url_imagen')->nullable()->default(null);
            $table->text('link')->nullable()->default(null);
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
        Schema::dropIfExists('slider_comunidades');
    }
}
