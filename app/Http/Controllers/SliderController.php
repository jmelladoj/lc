<?php

namespace App\Http\Controllers;

use App\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    //
    public function index(){      
        return ['sliders' => Slider::orderBy('created_at', 'desc')->get()];
    }

    public function indexHome(){      
        return ['sliders' => Slider::where('inicio', 1)->orderBy('created_at', 'desc')->get()];
    }

    public function crearOactualizar(Request $request){
        if ($request->hasFile('imagen_slider')) {

            $slider = Slider::updateOrCreate(
                ['id' => $request->slider_id],
                ['texto' => $request->texto,
                 'color' => $request->color,
                 'link' => $request->link
                ]
            );

            $img_slider = $request->file('imagen_slider');
            
            if($slider->url_imagen != null) { Storage::disk('public')->delete($slider->url_imagen); }
            
            $url = Storage::disk('public')->putFile(
                'sliders', $img_slider
            );

            $slider = Slider::updateOrCreate(['id' => $slider->id], ['url_imagen' => $url]);
        }  
    }

    public function ubicaciones(Request $request){
        Slider::updateOrCreate(
            ['id' => $request->slider_id],
            ['inicio' => $request->inicio,
             'descanso_uno' => $request->descanso_uno,
             'descanso_dos' => $request->descanso_dos,
             'pagina_nosotros' => $request->pagina_nosotros,
             'pagina_contacto' => $request->pagina_contacto,
             'pagina_comunidad' => $request->pagina_comunidad,
             'pagina_servicios' => $request->pagina_servicios 
            ]
        );
    }
    public function eliminar(Request $request){
        Slider::findOrFail($request->id)->delete();
    }
}


