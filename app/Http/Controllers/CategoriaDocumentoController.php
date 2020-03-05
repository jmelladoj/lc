<?php

namespace App\Http\Controllers;

use App\CategoriaDocumento;
use App\Documento;
use Illuminate\Http\Request;

class CategoriaDocumentoController extends Controller
{
    //
    public function index(){
        return ['categorias' => CategoriaDocumento::orderBy('nombre', 'asc')->get()];
    }

    public function indexHome(){
        return ['categorias' => CategoriaDocumento::orderBy('nombre', 'asc')->get()];
    }

    public function crearOactualizar(Request $request){
        CategoriaDocumento::updateOrCreate(
            ['id' => $request->categoria_id],
            ['nombre' => $request->nombre]
        );
    }

    public function eliminar(Request $request){
        Documento::where('categorias_documentos_id', $request->id)->update(['categorias_documentos_id' => null]);
        CategoriaDocumento::findOrFail($request->id)->delete();
    }

    public function restaurar(Request $request){
        CategoriaDocumento::withTrashed()->find($request->id)->restore();
    }
}
