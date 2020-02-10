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

    public function indexUbicacion($ubicacion){  
        switch ($ubicacion) {
            case 1:
                $sliders = Slider::where('descanso_uno', 1)->orderBy('created_at', 'desc')->get();
                break;
            case 2:
                $sliders = Slider::where('descanso_dos', 1)->orderBy('created_at', 'desc')->get();
                break;
            case 3:
                $sliders = Slider::where('pagina_nosotros', 1)->orderBy('created_at', 'desc')->get();
                break;
            case 4:
                $sliders = Slider::where('pagina_contacto', 1)->orderBy('created_at', 'desc')->get();
                break;
            case 5:
                $sliders = Slider::where('pagina_comunidad', 1)->orderBy('created_at', 'desc')->get();
                break;
            case 6:
                $sliders = Slider::where('pagina_servicios', 1)->orderBy('created_at', 'desc')->get();
                break;
        }

        return ['sliders' => $sliders];
    }

    public function crearOactualizar(Request $request){
        
        $slider = Slider::updateOrCreate(
            ['id' => $request->slider_id],
            [
                'texto' => $request->texto,
                'color' => $request->color,
                'link' => '/intranet/' . $request->link,
                'subtexto' => $request->subtexto,
                'subcolor' =>  $request->subcolor,
                'tipo_persona' => $request->tipo_persona == 'null' ? NULL : $request->tipo_persona,
                'inicio' => 1,
                'descanso_uno' => 1,
                'descanso_dos' => 1,
                'pagina_nosotros' => 1,
                'pagina_contacto' => 1,
                'pagina_comunidad' => 1,
                'pagina_servicios' => 1
            ]
        );

        if ($request->hasFile('imagen_slider')) {
            if($slider->url_imagen != null) { Storage::disk('public')->delete($slider->url_imagen); }
            
            Slider::updateOrCreate(['id' => $slider->id], ['url_imagen' => Storage::disk('public')->putFile('sliders', $request->file('imagen_slider'))]);
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


