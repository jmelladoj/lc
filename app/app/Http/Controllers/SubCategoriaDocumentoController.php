<?php

namespace App\Http\Controllers;

use App\SubCategoriaDocumento;
use Illuminate\Http\Request;

class SubCategoriaDocumentoController extends Controller
{
    //
    public function index($id){      
        return ['subcategorias' => SubCategoriaDocumento::where('categorias_documentos_id', $id)->orderBy('nombre', 'desc')->get()];
    }

    public function crearOactualizar(Request $request){
        SubCategoriaDocumento::updateOrCreate(
            ['id' => $request->subcategoria_id],
            ['nombre' => $request->nombre,
             'categorias_documentos_id' => $request->categoria_id]
        );
    }

    public function eliminar(Request $request){
        SubCategoriaDocumento::findOrFail($request->id)->delete();
    }

    public function restaurar(Request $request){
        SubCategoriaDocumento::withTrashed()->find($request->id)->restore();
    }
}
