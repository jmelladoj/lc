<?php

namespace App\Http\Controllers;

use App\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentoController extends Controller
{
    //
    public function index($estado){      
        return ['documentos' => Documento::where('estado', $estado)->orderBy('titulo', 'desc')->get()];
    }

    public function crearOactualizar(Request $request){
        $documento = Documento::updateOrCreate(
            ['id' => $request->documento_id],
            ['titulo' => $request->titulo,
                'descripcion' => $request->descripcion,
                'codigo' => $request->codigo,
                'codigo_interno' => $request->codigo_interno,
                'valor' => $request->valor,
                'clasificacion' => $request->clasificacion,
                'cantidad_descargas' => $request->cantidad_descargas,
                'categoria_documentos_id' => $request->categoria_id,
                'estado' => $request->estado,
                'user_id' => \Auth::user()->id
            ]
        );
        
        if ($request->hasFile('documento')) {
            $url = Storage::disk('public')->putFile(
                'documentos', $request->file('documento')
            );

            Documento::updateOrCreate(['id' => $documento->id], 
                                    ['documento_url' => $url,
                                    'extension' => $request->file('documento')->getClientOriginalExtension(),
                                    'version' => $documento->version += 1]);
        }  
    }
    public function eliminar(Request $request){
        Documento::findOrFail($request->id)->delete();
    }
}
