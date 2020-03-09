<?php

namespace App\Http\Controllers;

use App\Documento;
use App\Mail\SolicitarDocumento;
use App\Notifications\SolicitudDocumento as AppSolicitudDocumento;
use App\SolicitudDocumento;
use App\User;
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
                return ['documentos' => Documento::where('estado', 1)->with('categoria')->orderBy('created_at', 'desc')->get()];
                break;
            case 2:
                return ['documentos' => Documento::where('estado', 0)->with('categoria')->orderBy('created_at', 'desc')->get()];
                break;
            case 3:
                return ['documentos' => Documento::where('user_id', Auth::id())->orderBy('created_at', 'asc')->get()];
                break;
        }
    }

    public function indexHome($tipo){
        switch ($tipo) {
            case 1:
                $documentos = Documento::where('seccion_nuevo', 1)->where('estado', 1)->with('usuario')->orderBy('updated_at', 'desc')->get();
                break;
            case 2:
                $documentos = Documento::where('seccion_descargados', 1)->where('estado', 1)->with('usuario')->orderBy('updated_at', 'desc')->get();
                break;
        }

        foreach($documentos AS $d){
            $d->imagen = $d->img;
        }

        return ['documentos' => $documentos];
    }

    public function indexBusqueda($categoria){
        $documentos = Documento::where('estado', 1)->where('categorias_documentos_id', $categoria)->with('usuario')->orderBy('updated_at', 'asc')->get();

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
                'valor' => $request->valor,
                'seccion_nuevo' => $request->seccion_nuevo,
                'seccion_descargados' => $request->seccion_descargados,
                'categorias_documentos_id' => $request->categoria_id == 0 ? null : $request->categoria_id,
                'estado' => $request->estado,
                'user_id' => Auth::user()->id
            ]
        );

        if ($request->hasFile('documento')) {
            $url = Storage::disk('public')->putFile('documentos', $request->file('documento'));
            Documento::updateOrCreate(['id' => $documento->id], ['documento_url' => $url, 'extension' => $request->file('documento')->getClientOriginalExtension(),'version' => $documento->version += 1]);
        }

        if ($request->hasFile('documento_uno')) {
            $url = Storage::disk('public')->putFile('vista_documentos', $request->file('documento_uno'));
            Documento::updateOrCreate(['id' => $documento->id], ['url_imagen_vista_uno' => $url]);
        }

        if ($request->hasFile('documento_dos')) {
            $url = Storage::disk('public')->putFile('vista_documentos', $request->file('documento_dos'));
            Documento::updateOrCreate(['id' => $documento->id], ['url_imagen_vista_dos' => $url]);
        }
    }
    public function eliminar(Request $request){
        Documento::findOrFail($request->id)->delete();
    }

    public function solicitarDocumento(Request $request){
        $usuario = Auth::user();

        if($request->pago <= $usuario->saldo){

            SolicitudDocumento::create([
                'user_id' => Auth::id(),
                'descripcion' => $request->descripcion,
                'valor' => $request->pago,
                'plazo' => $request->plazo
            ]);

            $usuario = User::find(1);
            $usuario->notify(new AppSolicitudDocumento('Ha solicitado un documento.', Auth::user(), 'fa fa-search', 1));

            if(!Mail::to('contacto@prevencionlebenco.cl')->send(new SolicitarDocumento(Auth::user(), $request->descripcion, $request->plazo, $request->pago))){
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

    public function descargar(Request $request, $id){

        $documento = Documento::find($id);
        $usuario = Auth::user();

        if($usuario->tipo_usuario < 3){
            return ['documento' => $documento, 'clase' => 'success'];
        } else if($usuario->saldo >= $documento->valor){
            $usuario->saldo -= $documento->valor;
            $usuario->save();

            $documento->cantidad_descargas += 1;
            $documento->save();

            return ['documento' => $documento, 'clase' => 'success'];
        } else {
            return ['mensaje' => 'No tienes saldo para usar el servicio, por favor recarga e intenta nuevamente', 'clase' => 'error'];
        }
    }
}
