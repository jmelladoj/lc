<?php

namespace App\Http\Controllers;

use App\SolicitudDocumento;
use Illuminate\Http\Request;

class SolicitudDocumentoController extends Controller
{
    //
    public function index(){      
        return ['solicitudes' => SolicitudDocumento::with('usuario')->orderBy('created_at', 'desc')->get()];
    }
}
