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

        $general->terminos_url = $request->terminos;
        $general->mensaje_trabaja = $request->mensaje_trabaja;

        $general->save();
    }

}
