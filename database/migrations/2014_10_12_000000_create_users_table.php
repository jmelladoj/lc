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
            $table->string('nombre_fantasia')->nullable()->default(NULL);
            $table->string('giro_comercial')->nullable()->default(NULL);

            $table->string('run')->unique();
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable()->default(NULL);
            $table->string('password')->nullable();

            //Datos top five
            $table->boolean('comunidad_pyme')->nullable()->default(false);
            $table->boolean('top_five')->nullable()->default(false);
            $table->integer('posicion')->nullable()->default(0);
            $table->integer('likes')->nullable()->default(0);
            $table->integer('dislikes')->nullable()->default(0);

            //Datos Personales
            $table->string('fecha_nacimiento')->nullable()->default(NULL);
            $table->integer('telefono')->nullable()->default(NULL);
            $table->string('direccion')->nullable()->default(NULL);
            $table->integer('hijos')->nullable()->default(0);
            $table->string('estado_civil')->nullable()->default(NULL);

            //Datos academicos
            $table->string('casa_estudio')->nullable()->default(NULL);
            $table->string('ramo_favorito')->nullable()->default(NULL);
            $table->string('ramo_odiado')->nullable()->default(NULL);
            $table->string('titulo')->nullable()->default(NULL);
            $table->string('fecha_titulo')->nullable()->default(NULL);
            $table->text('seremi_o_practica')->nullable()->default(NULL);
            $table->text('software')->nullable()->default(NULL);
            $table->text('experiencia')->nullable()->default(NULL);

            //Datos del ejercicio
            $table->text('amigo')->nullable()->default(NULL);

            $table->unsignedBigInteger('profesion_id')->nullable()->default(NULL);
            $table->foreign('profesion_id')->references('id')->on('profesiones');

            $table->integer('tiempo_experiencia')->nullable()->default(NULL);
            $table->string('otro_rubro')->nullable()->default(NULL);
            $table->integer('porcentaje_terreno')->nullable()->default(NULL);
            $table->integer('porcentaje_oficina')->nullable()->default(NULL);
            $table->text('especializacion')->nullable()->default(NULL);
            $table->string('habilidad_sobresaliente')->nullable()->default(NULL);
            $table->string('habilidad_mejora')->nullable()->default(NULL);
            $table->integer('preferencia_laboral')->nullable()->default(null);
            $table->text('emprendimiento')->nullable()->default(NULL);
            $table->text('enterarse')->nullable()->default(NULL);
            $table->text('coaching')->nullable()->default(NULL);
            $table->text('ultimo_trabajo')->nullable()->default(NULL);
            $table->string('ultimo_empresa')->nullable()->default(NULL);
            $table->string('rubro_empresa')->nullable()->default(NULL);
            $table->string('organismo_administrador_empresa')->nullable()->default(NULL);

            //Datos facturación
            $table->string('nombre_facturacion')->nullable()->default(NULL);
            $table->string('run_facturacion')->nullable()->default(NULL);
            $table->string('email_facturacion')->nullable()->default(NULL);
            $table->string('nombre_representante_facturacion')->nullable()->default(NULL);
            $table->integer('telefono_facturacion')->nullable()->default(null);

            $table->integer('tipo_usuario')->nullable()->default(3);
            $table->integer('tipo_persona')->nullable()->default(1);
            $table->integer('mailing')->nullable()->default(0);
            $table->integer('saldo')->default(1000);
            $table->boolean('lista_negra')->default(false);

            //Datos pyme
            $table->integer('empresa_familiar')->nullable()->default(0);
            $table->integer('tiempo_funcionamiento')->nullable()->default(null);
            $table->integer('cantidad_trabajadores')->nullable()->default(null);
            $table->integer('tiene_sitio')->nullable()->default(0);
            $table->text('sitio_web')->nullable()->default(null);
            $table->text('nombre_contratistas')->nullable()->default(null);

            //Validar usuario
            $table->integer('usuario_perfil')->nullable()->default(0);
            $table->integer('usuario_academico')->nullable()->default(0);
            $table->integer('usuario_ejercicio')->nullable()->default(0);
            $table->integer('pyme_comercial')->nullable()->default(0);
            $table->integer('pyme_datos')->nullable()->default(0);
            $table->integer('pyme_facturacion')->nullable()->default(0);
            $table->integer('presiona_tabla_vip')->nullable()->default(0);
            $table->integer('situacion_actual')->nullable()->default(null);
            $table->text('temporada_alta')->nullable()->default(null);
            $table->text('descripcion_negocio')->nullable()->default(null);
            $table->text('descripcion_servicio')->nullable()->default(null);
            $table->text('otra_forma')->nullable()->default(null);
            $table->text('descripcion_administrador')->nullable()->default(null);


            $table->string('url_perfil')->default('img/perfil.png');

            $table->string('archivo_usuario')->nullable()->default(null);
            $table->string('nombre_archivo_usuario')->nullable()->default(null);

            $table->unsignedBigInteger('comuna_id')->nullable()->default(NULL);
            $table->foreign('comuna_id')->references('id')->on('comunas');

            $table->unsignedBigInteger('categorias_usuarios_id')->default(1);
            $table->foreign('categorias_usuarios_id')->references('id')->on('categoria_usuarios');

            $table->unsignedBigInteger('rubro_id')->nullable()->default(null);
            $table->foreign('rubro_id')->references('id')->on('rubros');

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
