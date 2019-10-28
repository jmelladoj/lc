<?php

namespace App\Http\Controllers;

use App\CategoriaDocumento;
use Illuminate\Http\Request;

class CategoriaDocumentoController extends Controller
{
    //
    public function index(){      
        return ['categorias' => CategoriaDocumento::orderBy('nombre', 'desc')->get()];
    }

    public function indexHome(){
        return ['categorias' => CategoriaDocumento::orderBy('nombre', 'desc')->get()];
    }
    
    public function crearOactualizar(Request $request){
        CategoriaDocumento::updateOrCreate(
            ['id' => $request->categoria_id],
            ['nombre' => $request->nombre]
        );
    }

    public function eliminar(Request $request){
        CategoriaDocumento::findOrFail($request->id)->delete();
    }

    public function restaurar(Request $request){
        CategoriaDocumento::withTrashed()->find($request->id)->restore();
    }
}
