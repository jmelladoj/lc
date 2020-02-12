<?php

namespace App\Http\Controllers;

use App\Asesoria;
use App\InvitacionUsuario;
use App\Mail\InvitarAmigo;
use App\Mail\RecuperarContrasena;
use App\Mail\SolicitarAsesoria;
use App\Notifications\Alerta;
use App\Notifications\Asesoria as AppAsesoria;
use App\User;
use App\Valoracion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UsuarioController extends Controller
{
    //
    public function index($tipo){

        switch ($tipo) {
            case 1:
                return ['usuarios' => User::withTrashed()->orderBy('nombre', 'desc')->get()];
                break;
            case 2:
                return ['usuarios' => User::withTrashed()->where('lista_negra', 1)->orderBy('nombre', 'desc')->get()];
                break;
        }
    }

    public function indexPymes($tipo){
        switch ($tipo) {
            case 1:
                $usuarios = User::where('tipo_persona', 2)->where('top_five', 1)->with('comuna')->orderBy('nombre', 'desc')->limit(5)->get();

                foreach($usuarios as $usuario){
                    $usuario->likes = $usuario->cantidadLike > 0 ? round((100 * $usuario->cantidadLike / ($usuario->cantidadLike + $usuario->cantidadDislike)) ,0) : 0;
                    $usuario->dislikes = $usuario->cantidadDislike > 0 ? round((100 * $usuario->cantidadDislike / ($usuario->cantidadLike + $usuario->cantidadDislike)) ,0) : 0;
                }

                return ['usuarios' => $usuarios];
                break;
            case 2:
                $usuarios = User::where('tipo_persona', 2)->where('comunidad_pyme', 1)->with('comuna')->orderBy('nombre', 'desc')->limit(10)->get();

                foreach($usuarios as $usuario){
                    $usuario->likes = $usuario->cantidadLike > 0 ? round((100 * $usuario->cantidadLike / ($usuario->cantidadLike + $usuario->cantidadDislike)) ,0) : 0;
                    $usuario->dislikes = $usuario->cantidadDislike > 0 ? round((100 * $usuario->cantidadDislike / ($usuario->cantidadLike + $usuario->cantidadDislike)) ,0) : 0;
                }

                return ['usuarios' => $usuarios];
                break;
        }
    }

    public function valoraciones($id){
        return ['valoraciones' => Valoracion::where('user_id', $id)->orderBy('created_at')->get()];
    }

    public function usuariosTablaVip(){
        return ['usuarios' => User::where('top_five', 1)->with('comuna')->orderBy('posicion', 'desc')->orderBy('likes', 'desc')->get()];
    }

    public function usuariosTablaComunidad(){
        $usuarios = User::where('comunidad_pyme', 1)->with('comuna')->orderBy('posicion', 'desc')->orderBy('likes', 'desc')->get();

        return ['usuarios' => $usuarios];
    }

    public function especifico($id){
        return ['usuario' => User::where('id', $id)->with('categoria')->first()];
    }

    public function crearOactualizar(Request $request){

        $usuario = User::updateOrCreate(
            ['id' => $request->usuario_id],
            [
                'nombre' => $request->nombre,
                'nombre_fantasia' => $request->nombre_fantasia,
                'giro_comercial' => $request->giro_comercial,
                'run' => $request->run,
                'email' => $request->email,
                'tipo_usuario' => $request->tipo_usuario,
                'tipo_persona' => $request->tipo_persona,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'telefono' => $request->telefono,
                'direccion' => $request->direccion,
                'comuna_id' => $request->comuna_id == 0 ? null : $request->comuna_id,
                'hijos' => $request->hijos,
                'estado_civil' => $request->estado_civil,
                'casa_estudio' => $request->casa_estudio,
                'ramo_favorito' => $request->ramo_favorito,
                'ramo_odiado' => $request->ramo_odiado,
                'titulo' => $request->titulo,
                'fecha_titulo' => $request->fecha_titulo,
                'seremi_o_practica' => $request->seremi_o_practica,
                'software' => $request->software,
                'experiencia' => $request->experiencia,
                'amigo' => $request->amigo,
                'profesion_id' => $request->profesion_id,
                'otro_rubro' => $request->otro_rubro,
                'porcentaje_terreno' => $request->porcentaje_terreno,
                'porcentaje_oficina' => $request->porcentaje_oficina,
                'especializacion' => $request->especializacion,
                'habilidad_sobresaliente' => $request->habilidad_sobresaliente,
                'habilidad_mejora' => $request->habilidad_mejora,
                'preferencia_laboral' => $request->preferencia_laboral,
                'emprendimiento' => $request->emprendimiento,
                'enterarse' => $request->enterarse,
                'coaching' => $request->coaching,
                'tiempo_experiencia' => $request->tiempo_experiencia,
                'ultimo_trabajo' => $request->ultimo_trabajo,
                'ultimo_empresa' => $request->ultimo_empresa,
                'rubro_empresa' => $request->rubro_empresa,
                'organismo_administrador_empresa' => $request->organismo_administrador_empresa,
                'comunidad_pyme' => $request->comunidad_pyme,
                'nombre_facturacion' => $request->nombre_facturacion,
                'run_facturacion' => $request->run_facturacion,
                'email_facturacion' => $request->email_facturacion,
                'nombre_representante_facturacion' => $request->nombre_representante_facturacion,
                'telefono_facturacion' => $request->telefono_facturacion,
                'empresa_familiar' => $request->empresa_familiar,
                'tiempo_funcionamiento' => $request->tiempo_funcionamiento,
                'cantidad_trabajadores' => $request->cantidad_trabajadores,
                'tiene_sitio' => $request->tiene_sitio,
                'sitio_web' => $request->tiene_sitio == 1 ? $request->sitio_web : null,
                'nombre_contratistas' => $request->nombre_contratistas,
                'temporada_alta' => $request->temporada_alta,
                'descripcion_negocio' => $request->descripcion_negocio,
                'descripcion_servicio' => $request->descripcion_servicio,
                'otra_forma' => $request->otra_forma
            ]
        );

        $usuario = User::find($usuario->id);

        if($request->usuario_perfil != 0){
            $usuario->usuario_perfil = 1;
        }

        if($request->usuario_academico != 0){
            $usuario->usuario_academico = 1;
        }

        if($request->usuario_ejercicio != 0){
            $usuario->usuario_ejercicio = 1;
        }

        if($request->pyme_comercial != 0){
            $usuario->pyme_comercial = 1;
        }

        if($request->pyme_datos != 0){
            $usuario->pyme_datos = 1;
        }

        if($request->pyme_facturacion != 0){
            $usuario->pyme_facturacion = 1;
        }


        $usuario->save();

        if($usuario->usuario_perfil == 1 && $usuario->usuario_academico == 1 && $usuario->usuario_ejercicio == 1){
            $user = User::find(1);
            $user->notify(new Alerta('Ha completado su perfil', $user, "", 'fa fa-star', 11));
        }

        if($usuario->pyme_comercial == 1 && $usuario->pyme_datos == 1){
            $user = User::find(1);
            $user->notify(new Alerta('Ha completado su perfil', $user, "", 'fa fa-star', 11));
        }

        if($request->password != ''){
            User::updateOrCreate(['id' => $usuario->id], ['password' => bcrypt($request->password)]);
        }

        if($request->coaching == 1 && $usuario->coaching == 0){
            $user = User::find(1);
            $user->notify(new Alerta($usuario->tipo_persona != 2 ? 'Coaching' : 'Puntos de vista', $usuario, '', 'fa fa-graduation-cap', 15));
        }

    }

    public function actualizar_usuario_tabla_vip(Request $request){

        $usuario = User::find($request->id);
        $usuario->posicion = $request->posicion;
        $usuario->likes = $request->likes;
        $usuario->dislikes = $request->dislikes;
        $usuario->save();
    }

    public function imagen(Request $request){
        $usuario = User::find($request->usuario_id);
        if($usuario->url_perfil != 'img/perfil.svg') { Storage::disk('public')->delete($usuario->url_perfil); }

        if ($request->hasFile('img_perfil')) {
            User::updateOrCreate(['id' => $usuario->id], ['url_perfil' => Storage::disk('public')->putFile('perfiles', $request->file('img_perfil'))]);
        } else {
            User::updateOrCreate(['id' => $usuario->id], ['url_perfil' => 'img/perfil.svg']);
        }
    }

    public function eliminar(Request $request){
        User::find($request->id)->delete();
    }

    public function restaurar(Request $request){
        User::withTrashed()->find($request->id)->restore();
    }

    public function saldo(Request $request){
        $usuario = User::find($request->usuario_id);
        $usuario->saldo += $request->nuevo_saldo;
        $usuario->save();
    }

    public function saldo_disponible(){
        return ['saldo_disponible' => Auth::user()->saldo];
    }

    public function blacklistAgregar(Request $request){
        User::updateOrCreate(
            ['id' => $request->id],
            ['lista_negra' => true]
        );
    }

    public function blacklistQuitar(Request $request){
        User::updateOrCreate(
            ['id' => $request->id],
            ['lista_negra' => false]
        );
    }

    public function agregarTablaVip(Request $request){
        User::updateOrCreate(
            ['id' => $request->id],
            ['top_five' => 1]
        );
    }

    public function quitarTablaVip(Request $request){
        User::updateOrCreate(
            ['id' => $request->id],
            ['top_five' => 0]
        );
    }

    public function agregarComunidadPyme(Request $request){
        User::updateOrCreate(
            ['id' => $request->id],
            ['comunidad_pyme' => 1]
        );
    }

    public function quitarComunidadPyme(Request $request){
        User::updateOrCreate(
            ['id' => $request->id],
            ['comunidad_pyme' => 0]
        );
    }

    public function invitar_amigo(Request $request){
        if(!Mail::to($request->email)->send(new InvitarAmigo(Auth::user(), $request->email))){

            $usuario = User::find(1);
            $usuario->notify(new Alerta('Ha invitado a un amigo.', Auth::user(), $request->email, 'fa fa-share-alt', 8));

            InvitacionUsuario::create([
                'correo_invitado' => $request->email,
                'user_id' => Auth::id()
            ]);

            return ['mensaje' => 'Invitación enviada!, gracias por compartir nuestra comunidad Prevención LebenCo.', 'clase' => 'success'];
        } else {
            return ['mensaje' => 'Hemos tenido inconvenientes al generar tu invitación. Por favor intenta nuevamente!', 'clase' => 'error'];
        }
    }

    public function solicitarAsesoria(Request $request){

        Asesoria::create([ 'user_id' => Auth::id() ]);

        $usuario = User::find(1);
        $usuario->notify(new AppAsesoria('Ha solicitado una asesoría.', Auth::user(), 'fa fa-car', 2));
    }

    public function recuperar(Request $request){
        $usuario = User::where('email', $request->correo)->first();
        $clave_nueva = Str::random(10);

        $usuario->password = bcrypt($clave_nueva);

        $usuario->save();

        $user = User::find(1);

        if(!Mail::to($usuario->email)->send(new RecuperarContrasena($usuario, $clave_nueva))){
            $user->notify(new Alerta('Contraseña', $usuario, "", 'fa fa-key', 2));
            return ['mensaje' => 'Hemos enviado una nueva contraseña a tu email, procura revisar badeja spam.', 'clase' => 'success'];
        } else {
            return ['mensaje' => 'Hemos tenido inconvenientes en tu solicitud. Por favor intenta nuevamente!', 'clase' => 'error'];
        }
    }

    public function usuario_tabla_comunidad(Request $request){
        $usuario = Auth::user();
        $usuario->comunidad_pyme = $request->accion == 0 ? 1 : 0;
        $usuario->presiona_tabla_vip = 1;
        $usuario->save();

        $user = User::find(1);
        $user->notify(new Alerta('Tabla comunidad', $user, "", 'fa fa-table', 5));

    }

    public function usuario_tabla_vip(Request $request){
        if($request->accion == 0){
            $user = User::find(1);
            $user->notify(new Alerta('Tabla vip', $user, "", 'fa fa-table', 6));
        } else {
            $usuario = Auth::user();
            $usuario->top_five = 0;
            $usuario->save();
        }
    }
}
