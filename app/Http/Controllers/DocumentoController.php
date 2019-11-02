<?php

namespace App\Http\Controllers;

use App\Documento;
use App\Mail\SolicitarDocumento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

class DocumentoController extends Controller
{
    //
    public function index($tipo){      
        switch ($tipo) {
            case 1:
                return ['documentos' => Documento::where('estado', 1)->orderBy('created_at', 'desc')->get()];
                break;
            case 2:
                return ['documentos' => Documento::where('estado', 0)->orderBy('created_at', 'desc')->get()];
                break;
            case 3:
                return ['documentos' => Documento::where('user_id', Auth::id())->orderBy('created_at', 'asc')->get()];
                break;
        }
    }

    public function indexHome($tipo){  
        switch ($tipo) {
            case 1:
                $documentos = Documento::where('estado', 1)->orderBy('cantidad_descargas', 'desc')->get();
                break;
            case 2:
                $documentos = Documento::where('estado', 1)->orderBy('updated_at', 'asc')->get();
                break;
        }

        foreach($documentos AS $d){
            $d->imagen = $d->img;
        }

        return ['documentos' => $documentos];
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
                'categorias_documentos_id' => $request->categoria_id,
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

    public function solicitarDocumento(Request $request){
        $usuario = Auth::user();

        if($request->pago <= $usuario->saldo){
            if(! Mail::to('prueba@prevencionlebenco.cl')->cc('j.melladojimenez@gmail.com')->send(new SolicitarDocumento(Auth::user(), $request->descripcion, $request->plazo, $request->pago))){
                $usuario->saldo = $usuario->saldo - $request->pago;
                $usuario->save();
                return ['mensaje' => '¡Felicitaciones!, pronto serás contactado por Prevención LebenCo.', 'clase' => 'success'];
            } else {
                return ['mensaje' => 'Hemos tenido inconvenientes al generar tu invitación. Por favor intenta nuevamente!', 'clase' => 'error'];
            }
        } else {
            return ['mensaje' => 'No tienes saldo para usar el servicio, por favor recarga e intenta nuevamente', 'clase' => 'error'];
        }
    }

    public function descargar(Request $request){
        return ['documento' => Documento::find($request->id)];
    }
}
