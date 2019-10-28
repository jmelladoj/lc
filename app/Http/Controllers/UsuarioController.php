<?php

namespace App\Http\Controllers;

use App\Mail\InvitarAmigo;
use App\Mail\SolicitarAsesoria;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
    
    public function crearOactualizar(Request $request){
        

        if($request->password != ''){
            User::updateOrCreate(
                ['id' => $request->usuario_id],
                ['nombre' => $request->nombre,
                 'run' => $request->run,
                 'email' => $request->email,
                 'password' => bcrypt($request->password),
                 'tipo_usuario' => $request->tipo_usuario]
            );
        } else {
            User::updateOrCreate(
                ['id' => $request->usuario_id],
                ['nombre' => $request->nombre,
                 'run' => $request->run,
                 'email' => $request->email,
                 'tipo_usuario' => $request->tipo_usuario]
            );
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

    public function solicitarDocumento(Request $request){
        if(! Mail::to('prueba@prevencionlebenco.cl')->cc('j.melladojimenez@gmail.com')->send(new InvitarAmigo(Auth::user(), $request->email))){
            return ['mensaje' => 'Invitación enviada!, gracias por compartir nuestra comunidad Prevención LebenCo.', 'clase' => 'success'];
        } else {
            return ['mensaje' => 'Hemos tenido inconvenientes al generar tu invitación. Por favor intenta nuevamente!', 'clase' => 'error'];
        }
    }

    public function solicitarAsesoria(Request $request){
        if(! Mail::to('prueba@prevencionlebenco.cl')->cc('j.melladojimenez@gmail.com')->send(new SolicitarAsesoria(Auth::user()))){
            return ['mensaje' => 'Asesoría solicitada!, Dentro de un plazo de 24 horas el equipo de Prevención LebenCo. se contactara contigo.', 'clase' => 'success'];
        } else {
            return ['mensaje' => 'Hemos tenido inconvenientes tu solicitud. Por favor intenta nuevamente!', 'clase' => 'error'];
        }
    }
}
