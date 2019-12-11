<?php

namespace App\Http\Controllers;

use App\Asesoria;
use App\Mail\InvitarAmigo;
use App\Mail\RecuperarContrasena;
use App\Mail\SolicitarAsesoria;
use App\Notifications\Asesoria as AppAsesoria;
use App\User;
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
                $usuarios = User::where('tipo_persona', 1)->with('comuna')->orderBy('nombre', 'desc')->limit(5)->get();

                foreach($usuarios as $usuario){
                    $usuario->likes = $usuario->cantidadLike > 0 ? round((100 * $usuario->cantidadLike / ($usuario->cantidadLike + $usuario->cantidadDislike)) ,0) : 0;
                    $usuario->dislikes = $usuario->cantidadDislike > 0 ? round((100 * $usuario->cantidadDislike / ($usuario->cantidadLike + $usuario->cantidadDislike)) ,0) : 0;
                }

                return ['usuarios' => $usuarios];
                break;
            case 2:
                $usuarios = User::where('tipo_persona', 1)->with('comuna')->orderBy('nombre', 'desc')->limit(10)->get();

                foreach($usuarios as $usuario){
                    $usuario->likes = $usuario->cantidadLike > 0 ? round((100 * $usuario->cantidadLike / ($usuario->cantidadLike + $usuario->cantidadDislike)) ,0) : 0;
                    $usuario->dislikes = $usuario->cantidadDislike > 0 ? round((100 * $usuario->cantidadDislike / ($usuario->cantidadLike + $usuario->cantidadDislike)) ,0) : 0;
                }

                return ['usuarios' => $usuarios];
                break;
        }
    }

    public function especifico($id){
        return ['usuario' => User::where('id', $id)->with('categoria')->first()];
    }
    
    public function crearOactualizar(Request $request){
        
        $usuario = User::updateOrCreate(
            ['id' => $request->usuario_id],
            [
                'nombre' => $request->nombre,
                'run' => $request->run,
                'email' => $request->email,
                'tipo_usuario' => $request->tipo_usuario,
                'tipo_persona' => $request->tipo_persona,
                'fecha_nacimiento' => Carbon::createFromDate($request->fecha_nacimiento)->format('Y-m-d'),
                'telefono' => $request->telefono,
                'direccion' => $request->direccion,
                'comuna_id' => $request->comuna_id,
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
                'top_five' => $request->top_five,
            ]
        );

        if($request->password != ''){
            User::updateOrCreate(['id' => $usuario->id], ['password' => bcrypt($request->password)]);
        }

    }

    public function posicion(Request $request){

        $usuario_actual = User::find($request->id);

        if($request->posicion_actual == 0){
            User::updateOrCreate(['id' => $request->id], ['posicion' => $request->posicion]);
        } else if($request->posicion > 0){
            $usuario_antiguo = User::where('posicion', $request->posicion)->get()->first();
            

            if($usuario_antiguo){
                $usuario_antiguo->posicion = $request->posicion_actual;

                $usuario_actual->posicion = $request->posicion;

                $usuario_actual->save();
                $usuario_antiguo->save();
            } else {
                $usuario_actual->posicion = $request->posicion;
                $usuario_actual->save();
            }
        }

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
            ['top_five' => false]
        );
    }

    public function quitarTablaVip(Request $request){
        User::updateOrCreate(
            ['id' => $request->id],
            ['top_five' => false]
        );
    }

    public function agregarComunidadPyme(Request $request){
        User::updateOrCreate(
            ['id' => $request->id],
            ['comunidad_pyme' => false]
        );
    }

    public function quitarComunidadPyme(Request $request){
        User::updateOrCreate(
            ['id' => $request->id],
            ['comunidad_pyme' => false]
        );
    }

    public function solicitarDocumento(Request $request){
        if(! Mail::to('prueba@prevencionlebenco.cl')->cc('j.melladojimenez@gmail.com')->send(new InvitarAmigo(Auth::user(), $request->email))){
            return ['mensaje' => 'Invitación enviada!, gracias por compartir nuestra comunidad Prevención LebenCo.', 'clase' => 'success'];
        } else {
            return ['mensaje' => 'Hemos tenido inconvenientes al generar tu invitación. Por favor intenta nuevamente!', 'clase' => 'error'];
        }
    }

    public function solicitarAsesoria(Request $request){

        Asesoria::create([ 'user_id' => Auth::id() ]);

        $usuario = User::find(1);
        $usuario->notify(new AppAsesoria('Ha solicitado una asesoría.', Auth::user()->nombre, 'fa fa-car', 2));

        if(! Mail::to('prueba@prevencionlebenco.cl')->cc('j.melladojimenez@gmail.com')->send(new SolicitarAsesoria(Auth::user()))){
            return ['mensaje' => 'Asesoría solicitada!, Dentro de un plazo de 24 horas el equipo de Prevención LebenCo. se contactara contigo.', 'clase' => 'success'];
        } else {
            return ['mensaje' => 'Hemos tenido inconvenientes tu solicitud. Por favor intenta nuevamente!', 'clase' => 'error'];
        }
    }

    public function recuperar(Request $request){
        $usuario = User::where('email', $request->correo)->first();
        $clave_nueva = Str::random(30);

        $usuario->password = bcrypt($clave_nueva);

        $usuario->save();

        if(!Mail::to($usuario->email)->send(new RecuperarContrasena($usuario, $clave_nueva))){
            return ['mensaje' => 'Hemos enviado una nueva contraseña a tu email, procura revisar badeja spam.', 'clase' => 'success'];
        } else {
            return ['mensaje' => 'Hemos tenido inconvenientes en tu solicitud. Por favor intenta nuevamente!', 'clase' => 'error'];
        }
    }
}
