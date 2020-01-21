<?php

namespace App\Http\Controllers;

use App\Interes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InteresController extends Controller
{
    //
    public function index(){      
        return ['sitios' => Interes::orderBy('nombre', 'asc')->get()];
    }

    public function crearOactualizar(Request $request){
        
        $interes = Interes::updateOrCreate(
            ['id' => $request->sitio_id],
            [
                'nombre' => $request->nombre,
                'link' => $request->link
            ]
        );

        if ($request->hasFile('imagen_sitio')) {
            if($interes->url_imagen != null) { Storage::disk('public')->delete($interes->url_imagen); }
            
            interes::updateOrCreate(['id' => $interes->id], ['url_imagen' => Storage::disk('public')->putFile('interes', $request->file('imagen_sitio'))]);
        }  
    }

    public function eliminar(Request $request){
        Interes::find($request->id)->delete();
    }
}
