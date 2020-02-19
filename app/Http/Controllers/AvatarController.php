<?php

namespace App\Http\Controllers;

use App\Avatar;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AvatarController extends Controller
{
    //
    public function index(){
        return ['avatares' => Avatar::orderBy('nombre', 'asc')->get()];
    }

    public function crearOactualizar(Request $request){

        if ($request->hasFile('imagen_avatar')) {
            $avatar = Avatar::updateOrCreate(
                ['id' => $request->slider_id],
                [
                    'nombre' => $request->nombre
                ]
            );


            if($avatar->url_imagen != null) { Storage::disk('public')->delete($avatar->url_imagen); }

            Avatar::updateOrCreate(['id' => $avatar->id], ['url_imagen' => Storage::disk('public')->putFile('avatares', $request->file('imagen_avatar'))]);
        }
    }

    public function eliminar(Request $request){
        $avatar =  Avatar::find($request->id);

        User::where('url_perfil', $avatar->url_imagen)->update(['url_perfil' => 'img/perfil.png']);

        $avatar->delete();
    }
}
