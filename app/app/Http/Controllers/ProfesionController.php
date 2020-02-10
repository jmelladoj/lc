<?php

namespace App\Http\Controllers;

use App\Profesion;
use Illuminate\Http\Request;

class ProfesionController extends Controller
{
    //
    public function index($tipo){      
        switch ($tipo) {
            case 1:
                return ['profesiones' => Profesion::orderBy('tipo_persona', 'desc')->withTrashed()->orderBy('nombre', 'desc')->get()];
                break;
            case 2:
                return ['profesiones' => Profesion::orderBy('tipo_persona', 'desc')->orderBy('nombre', 'desc')->get()];
                break;
        }
    }

    public function crearOactualizar(Request $request){
        Profesion::updateOrCreate(
            ['id' => $request->rubro_id],
            ['nombre' => $request->nombre,
             'tipo_persona' => $request->tipo_persona]
        );
    }

    public function eliminar(Request $request){
        Profesion::find($request->id)->delete();
    }

    public function restaurar(Request $request){
        Profesion::withTrashed()->find($request->id)->restore();
    }
}
