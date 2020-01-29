<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('texto');
            $table->string('color');
            $table->string('subtexto')->nullable()->default(null);
            $table->string('subcolor')->nullable()->default(null);
            $table->string('url_imagen')->nullable()->default(null);
            $table->text('link');
            $table->smallInteger('tipo_persona')->nullable()->default(null);
            $table->boolean('inicio')->default(false);
            $table->boolean('descanso_uno')->default(false);
            $table->boolean('descanso_dos')->default(false);
            $table->boolean('pagina_nosotros')->default(false);
            $table->boolean('pagina_contacto')->default(false);
            $table->boolean('pagina_comunidad')->default(false);
            $table->boolean('pagina_servicios')->default(false);
            $table->string('letra_titulo')->nullable()->default('46');
            $table->string('alineacion_titulo')->nullable()->default('text-center');
            $table->string('letra_sub_titulo')->nullable()->default('36');
            $table->string('alineacion_sub_titulo')->nullable()->default('text-center');
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
        Schema::dropIfExists('sliders');
    }
}
