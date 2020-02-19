<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('logo_url')->nullable()->default(null);
            $table->string('favicon_url')->nullable()->default(null);
            $table->string('logo_fot_url')->nullable()->default(null);
            $table->string('logo_escritorio_url')->nullable()->default(null);
            $table->string('terminos_url')->nullable()->default(null);
            $table->string('privacidad_url')->nullable()->default(null);
            $table->string('satisfaccion_url')->nullable()->default(null);
            $table->string('derechos_url')->nullable()->default(null);
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
        Schema::dropIfExists('generales');
    }
}
