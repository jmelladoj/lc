<?php

namespace App\Http\Controllers;

use App\SliderComunidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderComunidadController extends Controller
{
    //
    public function index(){      
        return ['sliders' => SliderComunidad::orderBy('created_at', 'desc')->get()];
    }

    public function indexHome(){      
        return ['sliders' => SliderComunidad::orderBy('created_at', 'desc')->get()];
    }

    public function crearOactualizar(Request $request){
        
        $slider = SliderComunidad::updateOrCreate(
            ['id' => $request->slider_id],
            [
                'texto' => $request->texto_slider,
                'subtexto' => $request->subtexto,
                'color' => $request->color,
                'subcolor' => $request->subcolor,
                'texto_boton' => $request->texto_boton,
                'texto_modal' => $request->texto_modal,
                'link' => $request->link
            ]
        );

        if ($request->hasFile('imagen_slider')) {
            if($slider->url_imagen != null) { Storage::disk('public')->delete($slider->url_imagen); }
            
            SliderComunidad::updateOrCreate(['id' => $slider->id], ['url_imagen' => Storage::disk('public')->putFile('sliders_comunidad', $request->file('imagen_slider'))]);
        }  
    }

    public function eliminar(Request $request){
        SliderComunidad::findOrFail($request->id)->delete();
    }
}
