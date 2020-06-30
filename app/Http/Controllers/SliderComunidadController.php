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
                'subtexto' => $request->subtexto == 'null' ? NULL : $request->subtexto,
                'color' => $request->color,
                'subcolor' => $request->subcolor,
                'texto_boton' => $request->texto_boton,
                'texto_modal' => $request->texto_modal,
                'texto_alerta' => $request->texto_alerta,
                'link' => '/intranet/' . $request->link,
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

            SliderComunidad::updateOrCreate(['id' => $slider->id], ['url_imagen' => Storage::disk('public')->putFile('sliders_comunidad', $request->file('imagen_slider'))]);
        }
    }

    public function eliminar(Request $request){
        SliderComunidad::findOrFail($request->id)->delete();
    }

    public function duplicar(Request $request){
        $slider = SliderComunidad::where('id', $request->id)->first();

        SliderComunidad::updateOrCreate(
            ['id' => null],
            [
                'texto' => $slider->texto,
                'subtexto' => $slider->subtexto,
                'color' => $slider->color,
                'subcolor' => $slider->subcolor,
                'texto_boton' => $slider->texto_boton,
                'texto_modal' => $slider->texto_modal,
                'texto_alerta' => $slider->texto_alerta,
                'link' => $slider->link,
                'letra_titulo' => $slider->letra_titulo,
                'alineacion_titulo' => $slider->alineacion_titulo,
                'letra_sub_titulo' => $slider->letra_sub_titulo,
                'alineacion_sub_titulo' => $slider->alineacion_sub_titulo,
                'link_alternativo_uno' => $slider->link_alternativo_uno,
                'link_alternativo_dos' => $slider->link_alternativo_dos,
                'url_imagen' => $slider->url_imagen,
                'texto_borde_externo' => $slider->texto_borde_externo,
                'texto_color_fondo' => $slider->texto_color_fondo,
                'parrafo' => $slider->parrafo,
                'parrafo_color' => $slider->parrafo_color,
                'letra_parrafo' => $slider->letra_parrafo,
                'alineacion_parrafo' => $slider->alineacion_parrafo,
                'subtitulo_borde_externo' => $slider->subtitulo_borde_externo,
                'subtitulo_color_fondo' => $slider->subtitulo_color_fondo,
                'parrafo_borde_externo' => $slider->parrafo_borde_externo,
                'parrafo_color_fondo' => $slider->parrafo_color_fondo
            ]
        );
    }
}
