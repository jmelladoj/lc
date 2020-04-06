<?php

namespace App\Http\Controllers;

use App\User;
use App\Venta;
use Illuminate\Http\Request;

class InformeController extends Controller
{
    //
    public function ventaContenido(){
            return ['items' => Venta::with('usuario')->get()];
    }

    public function clientesActivos(){
        return ['items' => User::where('tipo_usuario', 3)->orderBy('nombre')->with(['categoria', 'profesion', 'rubro'])->get()];
}
}
