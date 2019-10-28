<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->string('run');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable()->default(NULL);
            $table->string('password');
            $table->integer('tipo_usuario')->default(3);
            $table->integer('tipo_persona')->default(1);
            $table->integer('mailing')->default(0);
            $table->integer('saldo')->default(1000);
            $table->boolean('lista_negra')->default(false);
            $table->string('url_perfil')->default('img/perfil.svg');

            $table->unsignedBigInteger('categorias_usuarios_id')->default(1);
            $table->foreign('categorias_usuarios_id')->references('id')->on('categoria_usuarios');

            $table->rememberToken();
            $table->softDeletes();
            $table->datetime('last_login_at')->nullable();
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
        Schema::dropIfExists('users');
    }
}
