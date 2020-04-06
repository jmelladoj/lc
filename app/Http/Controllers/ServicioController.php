<?php

namespace App\Http\Controllers;

use App\Servicio;
use App\Subservicio;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class ServicioController extends Controller
{
    //
    public function index(){
        return ['servicios' => Servicio::orderBy('nombre', 'desc')->get()];
    }

    public function index_subservicios($id){
        return ['servicios' => Subservicio::where('servicio_id', $id)->orderBy('nombre', 'desc')->get()];
    }

    public function crearOactualizar(Request $request){
        $servicio = Servicio::updateOrCreate(
            ['id' => $request->servicio_id],
            ['nombre' => $request->nombre,
                'descripcion' => $request->descripcion
            ]
        );

        if ($request->hasFile('imagen_servicio')) {
            $img_servicio = $request->file('imagen_servicio');

            if($servicio->imagen_url != null) { Storage::disk('public')->delete($servicio->imagen_url); }

            $url = Storage::disk('public')->putFile(
                'servicios', $img_servicio
            );

            $servicio = Servicio::updateOrCreate(['id' => $servicio->id], ['imagen_url' => $url]);
        }
    }

    public function crear_actualizar_sub_servicio(Request $request){
        Subservicio::updateOrCreate(
            ['id' => $request->sub_servicio_id],
            [
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'servicio_id' => $request->servicio_id
            ]
        );
    }

    public function eliminar(Request $request){
        Servicio::find($request->id)->delete();
    }

    public function eliminar_sub_servicio(Request $request){
        Subservicio::find($request->id)->delete();
    }
    
}
