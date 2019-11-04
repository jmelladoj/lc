<?php

namespace App\Http\Controllers;

use App\Valoracion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ValoracionController extends Controller
{
    //
    public function valorar(Request $request){
        Valoracion::create([
            'user_id' => Auth::id(),
            'descripcion' => $request->descripcion,
            'tipo_votacion' => $request->accion
        ]);
    }
}
