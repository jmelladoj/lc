<?php

namespace App\Http\Controllers;

use App\Notifications\Alerta;
use App\ParticipanteSorteo;
use App\Sorteo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SorteoController extends Controller
{
    //
    public function index($tipo){
        switch ($tipo) {
            case 1:
                return ['sorteos' => Sorteo::orderBy('created_at', 'desc')->get()];
                break;
            case 2:
                return ['sorteos' => Sorteo::where('fecha', '>=', Carbon::now()->format('Y-m-d'))->where('tipo_persona', Auth::user()->tipo_persona)->orderBy('fecha', 'desc')->get()];
                break;
        }
    }

    public function crearOactualizar(Request $request){
        $sorteo = Sorteo::updateOrCreate(
            ['id' => $request->sorteo_id],
            ['titulo' => $request->titulo,
             'valor' => $request->valor,
             'premio' => $request->premio,
             'fecha' => $request->fecha,
             'tipo_persona' => $request->tipo_persona,
             'categorias_usuarios_id' => $request->categoria_usuario
            ]
        );


        if ($request->hasFile('imagen_sorteo')) {
            if($sorteo->url_imagen != null) { Storage::disk('public')->delete($sorteo->url_imagen); }

            Sorteo::updateOrCreate(['id' => $sorteo->id], ['url_imagen' => Storage::disk('public')->putFile('sorteos', $request->file('imagen_sorteo'))]);
        }
    }

    public function eliminar(Request $request){
        Sorteo::findOrFail($request->id)->delete();
    }

    public function concursar(Request $request){
        $sorteo = Sorteo::find($request->id);
        $usuario = Auth::user();

        if($sorteo->valor <= $usuario->saldo){

            $participanteSorteo = ParticipanteSorteo::create([
                'sorteo_id' => $request->id,
                'user_id' => $usuario->id
            ]);

            if($participanteSorteo){
                $usuario->saldo = $usuario->saldo - $sorteo->valor;
                $usuario->save();
            }

            $user = User::find(1);
            $user->notify(new Alerta('Ha participado en un concurso.', Auth::user(), "", 'fa fa-list-ol', 1));

            return ['mensaje' => 'Estas participando exitosamente por un ' . $sorteo->premio . ', recuerda que la fecha de termino es ' . $sorteo->fecha . '. Buena suerte', 'clase' => 'success'];
        } else {
            return ['mensaje' => 'No tienes saldo para usar el servicio, por favor recarga e intenta nuevamente', 'clase' => 'error'];
        }
    }
}
