<?php

namespace App\Http\Controllers;

use App\Asesoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsesoriaController extends Controller
{
    //
    public function index($tipo){
        switch ($tipo) {
            case 1:
                return ['asesorias' => Asesoria::with('usuario')->orderBy('created_at', 'desc')->get()];
                break;
            case 2:
                return ['asesorias' => Asesoria::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get()];
                break;
        }

    }
}
