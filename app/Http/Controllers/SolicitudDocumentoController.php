<?php

namespace App\Http\Controllers;

use App\SolicitudDocumento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SolicitudDocumentoController extends Controller
{
    //
    public function index(){      
        if(Auth::user()->tipo_usuario < 3){
            return ['solicitudes' => SolicitudDocumento::with('usuario')->orderBy('created_at', 'desc')->get()];
        } else {
            return ['solicitudes' => SolicitudDocumento::where('user_id', Auth::id())->with('usuario')->orderBy('created_at', 'desc')->get()];
        }
    }
}
