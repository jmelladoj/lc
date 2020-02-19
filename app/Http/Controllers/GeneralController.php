<?php

namespace App\Http\Controllers;

use App\General;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GeneralController extends Controller
{
    //
    public function indexGeneral(){
        return ['general' => General::find(1)];
    }

    public function actualizar(Request $request){
        $general = General::find(1);

        if ($request->hasFile('logo')){
            $logo = $request->file('logo');
            $nombre = 'logo.' . $request->file('logo')->getClientOriginalExtension();

            if($general->logo_url != null) { Storage::disk('public')->delete($general->logo_url); }

            $general->logo_url = Storage::disk('public')->putFileAs(
                'general', $logo, $nombre, 'public'
            );
        }

        if ($request->hasFile('favicon')){
            $favicon = $request->file('favicon');
            $nombre = 'favicon.' . $request->file('favicon')->getClientOriginalExtension();

            if($general->favicon_url != null) { Storage::disk('public')->delete($general->favicon_url); }

            $general->favicon_url = Storage::disk('public')->putFileAs(
                'general', $favicon, $nombre, 'public'
            );
        }

        if ($request->hasFile('logo_footer')){
            $logo_footer = $request->file('logo_footer');
            $nombre = 'logo_footer.' . $request->file('logo_footer')->getClientOriginalExtension();

            if($general->logo_fot_url != null) { Storage::disk('public')->delete($general->logo_fot_url); }

            $general->logo_fot_url = Storage::disk('public')->putFileAs(
                'general', $logo_footer, $nombre, 'public'
            );
        }

        if ($request->hasFile('logo_escritorio')){
            $logo_escritorio = $request->file('logo_escritorio');
            $nombre = 'logo_escritorio.' . $request->file('logo_escritorio')->getClientOriginalExtension();

            if($general->logo_escritorio_url != null) { Storage::disk('public')->delete($general->logo_escritorio_url); }

            $general->logo_escritorio_url = Storage::disk('public')->putFileAs(
                'general', $logo_escritorio, $nombre, 'public'
            );
        }

        if ($request->hasFile('terminos')){
            $terminos = $request->file('terminos');
            $nombre = 'terminos.' . $request->file('terminos')->getClientOriginalExtension();

            if($general->terminos_url != null) { Storage::disk('public')->delete($general->terminos_url); }

            $general->terminos_url = Storage::disk('public')->putFileAs(
                'general', $terminos, $nombre, 'public'
            );
        }

        if ($request->hasFile('privacidad')){
            $privacidad = $request->file('privacidad');
            $nombre = 'privacidad.' . $request->file('privacidad')->getClientOriginalExtension();

            if($general->privacidad_url != null) { Storage::disk('public')->delete($general->privacidad_url); }

            $general->privacidad_url = Storage::disk('public')->putFileAs(
                'general', $privacidad, $nombre, 'public'
            );
        }

        if ($request->hasFile('satisfaccion')){
            $satisfaccion = $request->file('satisfaccion');
            $nombre = 'satisfaccion.' . $request->file('satisfaccion')->getClientOriginalExtension();

            if($general->satisfaccion_url != null) { Storage::disk('public')->delete($general->satisfaccion_url); }

            $general->satisfaccion_url = Storage::disk('public')->putFileAs(
                'general', $satisfaccion, $nombre, 'public'
            );
        }

        if ($request->hasFile('derechos')){
            $derechos = $request->file('derechos');
            $nombre = 'derechos.' . $request->file('derechos')->getClientOriginalExtension();

            if($general->derechos_url != null) { Storage::disk('public')->delete($general->derechos_url); }

            $general->derechos_url = Storage::disk('public')->putFileAs(
                'general', $derechos, $nombre, 'public'
            );
        }

        $general->save();
    }

}
