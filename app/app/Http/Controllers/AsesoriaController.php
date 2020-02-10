<?php

namespace App\Http\Controllers;

use App\Asesoria;
use Illuminate\Http\Request;

class AsesoriaController extends Controller
{
    //
    public function index(){      
        return ['asesorias' => Asesoria::with('usuario')->orderBy('created_at', 'desc')->get()];
    }
}
