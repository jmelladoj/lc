<?php

namespace App\Http\Controllers;

use App\CategoriaUsuario;
use Illuminate\Http\Request;

class CategoriaUsuarioController extends Controller
{
    //
    public function index(){
        return ['categorias' => CategoriaUsuario::get()];
    }

    public function crearOactualizar(Request $request){
        CategoriaUsuario::updateOrCreate(
            ['id' => $request->categoria_id],
            ['nombre' => $request->nombre,
             'nivel' => $request->nivel,
             'gasto_inicio' => $request->gasto_inicio,
             'gasto_fin' => $request->gasto_fin,
             'color' => $request->color,
             'bonificacion' => $request->bonificacion]
        );
    }

    public function eliminar(Request $request){
        CategoriaUsuario::findOrFail($request->id)->delete();
    }

    public function restaurar(Request $request){
        CategoriaUsuario::withTrashed()->find($request->id)->restore();
    }
}
