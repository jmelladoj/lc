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
                'subtexto' => $request->subtexto == 'null' ? NULL : $request->subtexto,
                'subcolor' =>  $request->subcolor,
                'tipo_persona' => $request->tipo_persona == 'null' ? NULL : $request->tipo_persona,
                'inicio' => 1,
                'descanso_uno' => 1,
                'descanso_dos' => 1,
                'pagina_nosotros' => 1,
                'pagina_contacto' => 1,
                'pagina_comunidad' => 1,
                'pagina_servicios' => 1,
                'letra_titulo' => $request->letra_titulo,
                'alineacion_titulo' => $request->alineacion_titulo,
                'letra_sub_titulo' => $request->letra_sub_titulo,
                'alineacion_sub_titulo' => $request->alineacion_sub_titulo,
                'link_alternativo_uno' => $request->link_alternativo_uno == 'null' ? NULL : $request->link_alternativo_uno,
                'link_alternativo_dos' => $request->link_alternativo_dos == 'null' ? NULL : $request->link_alternativo_dos,
                'parrafo' => $request->parrafo,
                'parrafo_color' => $request->parrafo_color,
                'letra_parrafo' => $request->letra_parrafo,
                'alineacion_parrafo' => $request->alineacion_parrafo,
                'texto_borde_externo' => $request->texto_borde_externo == 'null' ? '0' : $request->texto_borde_externo,
                'texto_color_fondo' => $request->texto_color_fondo,
                'subtitulo_borde_externo' => $request->subtitulo_borde_externo == 'null' ? '0' : $request->subtitulo_borde_externo,
                'subtitulo_color_fondo' => $request->subtitulo_color_fondo,
                'parrafo_borde_externo' => $request->parrafo_borde_externo == 'null' ? '0' : $request->parrafo_borde_externo,
                'parrafo_color_fondo' => $request->parrafo_color_fondo
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

    public function duplicar(Request $request){
        $slider = Slider::where('id', $request->id)->first();

        Slider::updateOrCreate(
            ['id' => null],
            [
                'texto' => $slider->texto,
                'color' => $slider->color,
                'link' => $slider->link,
                'subtexto' => $slider->subtexto,
                'subcolor' =>  $slider->subcolor,
                'tipo_persona' => $slider->tipo_persona,
                'inicio' => 1,
                'descanso_uno' => 1,
                'descanso_dos' => 1,
                'pagina_nosotros' => 1,
                'pagina_contacto' => 1,
                'pagina_comunidad' => 1,
                'pagina_servicios' => 1,
                'letra_titulo' => $slider->letra_titulo,
                'alineacion_titulo' => $slider->alineacion_titulo,
                'letra_sub_titulo' => $slider->letra_sub_titulo,
                'alineacion_sub_titulo' => $slider->alineacion_sub_titulo,
                'link_alternativo_uno' => $slider->link_alternativo_uno,
                'link_alternativo_dos' => $slider->link_alternativo_dos,
                'parrafo' => $slider->parrafo,
                'parrafo_color' => $slider->parrafo_color,
                'letra_parrafo' => $slider->letra_parrafo,
                'alineacion_parrafo' => $slider->alineacion_parrafo,
                'url_imagen' => $slider->url_imagen,
                'texto_borde_externo' => $slider->texto_borde_externo,
                'texto_color_fondo' => $slider->texto_color_fondo,
                'subtitulo_borde_externo' => $slider->subtitulo_borde_externo,
                'subtitulo_color_fondo' => $slider->subtitulo_color_fondo,
                'parrafo_borde_externo' => $slider->parrafo_borde_externo,
                'parrafo_color_fondo' => $slider->parrafo_color_fondo
            ]
        );
    }
}


