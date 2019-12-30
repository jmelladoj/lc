<?php

namespace App\Http\Controllers;

use App\ParticipanteSeminario;
use App\Seminario;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SeminarioController extends Controller
{
    //
    public function index($tipo){
        switch ($tipo) {
            case 1:
                return ['seminarios' => Seminario::orderBy('created_at', 'desc')->get()];
                break;
            case 2:
                $seminarios_inscritos = ParticipanteSeminario::where('user_id', Auth::id())->get()->pluck('seminario_id');
                return ['seminarios' => Seminario::whereNotIn('id', $seminarios_inscritos)->where('fecha', '>=', Carbon::now()->format('Y-m-d'))->whereColumn('participantes', '<', 'capacidad')->where('tipo_persona', Auth::user()->tipo_persona)->orderBy('fecha', 'desc')->get()];
                break;
        }
    }

    public function indexParticipantes($id){
        return ['participantes' => ParticipanteSeminario::where('seminario_id', $id)->with('usuario')->orderBy('created_at', 'desc')->get()];
    }

    public function crearOactualizar(Request $request){
        $seminario = Seminario::updateOrCreate(
            ['id' => $request->seminario_id],
            [
                'titulo' => $request->titulo,
                'fecha' => $request->fecha,
                'valor' => $request->valor,
                'capacidad' => $request->capacidad,
                'descripcion' => $request->descripcion,
                'tipo_persona' => $request->tipo_persona
            ]
        );

        if ($request->hasFile('imagen_seminario')) {
            if($seminario->url_imagen != null) { Storage::disk('public')->delete($seminario->url_imagen); }

            Seminario::updateOrCreate(['id' => $seminario->id], ['url_imagen' => Storage::disk('public')->putFile('seminarios', $request->file('imagen_seminario'))]);
        }
    }

    public function eliminar(Request $request){
        Seminario::findOrFail($request->id)->delete();
    }

    public function participar(Request $request){
        $usuario = Auth::user();
        $seminario = Seminario::find($request->id);

        if($usuario->saldo >= $seminario->valor){
            $seminario->participantes += 1;
            $seminario->save();

            ParticipanteSeminario::create([
                'user_id' => Auth::id(),
                'seminario_id' => $request->id
            ]);

            $user = User::find(1);
            $user->notify(new Alerta('Ha participado en un seminario.', Auth::user(), 'fa fa-calendar', 1));

            return ['mensaje' => '¡Felicitaciones!, Te has incrito en el seminario ' . $seminario->titulo, 'clase' => 'success'];
        } else {
            return ['mensaje' => 'No tienes saldo para usar el servicio, por favor recarga e intenta nuevamente', 'clase' => 'error'];
        }
    }
}
