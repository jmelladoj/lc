<?php

namespace App\Http\Controllers;

use App\Valoracion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ValoracionController extends Controller
{
    //
    public function valorar(Request $request){
        Valoracion::updateOrCreate(
            [
                'id' => $request->id],
            [
                'nombre_usuario' => $request->autor != '' ? $request->autor : Auth::user()->nombre,
                'user_id' => $request->usuario_id,
                'descripcion' => $request->detalle,
                'tipo_votacion' => $request->tipo_votacion,
                'tipo_usuario_votacion' => Auth::user()->tipo_usuario,
                'autor' => Auth::id()
            ]
        );
    }

    public function borrar(Request $request){
        Valoracion::find($request->id)->delete();
    }
}
