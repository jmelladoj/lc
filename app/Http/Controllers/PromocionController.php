<?php

namespace App\Http\Controllers;

use App\Promocion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PromocionController extends Controller
{
    //
    public function index($tipo){
        switch ($tipo) {
            case 1:
                return ['promociones' => Promocion::orderBy('created_at', 'desc')->get()];
                break;
            case 2:
                return ['promociones' => Promocion::where('fecha', '>=', Carbon::now()->format('Y-m-d'))->where('categorias_usuarios_id', null)->orWhere('categorias_usuarios_id', Auth::user()->categoria->id)->where('tipo_persona', Auth::user()->tipo_persona)->orderBy('fecha', 'desc')->get()];
                break;
        }
    }

    public function crearOactualizar(Request $request){
        $sorteo = Promocion::updateOrCreate(
            ['id' => $request->sorteo_id],
            ['titulo' => $request->titulo,
             'fecha' => $request->fecha,
             'tipo_persona' => $request->tipo_persona,
             'categorias_usuarios_id' => $request->categoria_usuario
            ]
        );


        if ($request->hasFile('imagen_promocion')) {
            if($sorteo->url_imagen != null) { Storage::disk('public')->delete($sorteo->url_imagen); }

            Promocion::updateOrCreate(['id' => $sorteo->id], ['url_imagen' => Storage::disk('public')->putFile('promociones', $request->file('imagen_promocion'))]);
        }
    }

    public function eliminar(Request $request){
        Promocion::findOrFail($request->id)->delete();
    }
}
