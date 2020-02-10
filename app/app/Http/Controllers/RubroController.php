<?php

namespace App\Http\Controllers;

use App\Rubro;
use Illuminate\Http\Request;

class RubroController extends Controller
{
    //
    public function index($tipo){      
        switch ($tipo) {
            case 1:
                return ['rubros' => Rubro::orderBy('nombre', 'desc')->withTrashed()->orderBy('nombre', 'desc')->get()];
                break;
            case 2:
                return ['rubros' => Rubro::orderBy('nombre', 'desc')->orderBy('nombre', 'desc')->get()];
                break;
        }
    }

    public function crearOactualizar(Request $request){
        Rubro::updateOrCreate(
            ['id' => $request->rubro_id],
            ['nombre' => $request->nombre]
        );
    }

    public function eliminar(Request $request){
        Rubro::find($request->id)->delete();
    }

    public function restaurar(Request $request){
        Rubro::withTrashed()->find($request->id)->restore();
    }
}
