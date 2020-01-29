<?php

namespace App\Http\Controllers;

use App\Tip;
use Illuminate\Http\Request;

class TipController extends Controller
{
    //
    public function index(){
        return ['tips' => Tip::orderBy('created_at', 'desc')->get()];
    }

    public function crearOactualizar(Request $request){
        Tip::updateOrCreate(
            ['id' => $request->tip_id],
            [
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion
            ]
        );
    }

    public function eliminar(Request $request){
        Tip::findOrFail($request->id)->delete();
    }
}
