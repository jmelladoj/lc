<?php

namespace App\Http\Controllers;

use App\CategoriaDocumento;
use App\Pagina;
use App\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaginaController extends Controller
{
    //
    public function indexHomeNosotros(){
        $pagina = Pagina::find(1);

        return view('nosotros')->with(compact('pagina'));
    }

    public function indexHomeComunidad(){
        $pagina = Pagina::find(2);

        return view('comunidad')->with(compact('pagina'));
    }

    public function indexHomeServicios(){
        $pagina = Pagina::find(3);
        $servicios = Servicio::get();

        return view('servicios')->with(compact('pagina', 'servicios'));
    }

    public function indexComunidad(Request $request)
    {
        return ['pagina' => Pagina::find(2)];
    }

    public function indexNosotros(Request $request)
    {
        return ['contenido' => Pagina::find(1)->contenido];
    }

    public function indexServicios(Request $request)
    {
        return ['pagina' => Pagina::find(3)];
    }

    public function indexLogin(Request $request)
    {
        return ['pagina' => Pagina::find(4)];
    }

    public function indexHomePoliticas(Request $request){
        return view('politicas');
    }

    public function indexHomeBusqueda($id){
        $categoria = CategoriaDocumento::find($id);
        return view('busqueda')->with(compact('categoria'));
    }

    public function actualizarNosotros(Request $request){
        $pagina = Pagina::find(1);

        if ($request->hasFile('video')){
            $video = $request->file('video');
            $nombre = 'video_nosotros.' . $request->file('video')->getClientOriginalExtension();
            
            if($pagina->video_url != null) { Storage::disk('public')->delete($pagina->video_url); }
            
            $pagina->video_url = Storage::disk('public')->putFileAs(
                'general', $video, $nombre, 'public'
            );
        }

        if($request->contenido != null || $request->contenido != ''){
            $pagina->contenido = $request->contenido;
        }

        $pagina->save();

    }

    public function actualizarComunidad(Request $request){
        Pagina::where('id', 2)->update(['mensaje_uno' => $request->mensaje_uno, 'mensaje_dos' => $request->mensaje_dos]);
    }

    public function actualizarServicios(Request $request){
        Pagina::where('id', 3)->update(['mensaje_uno' => $request->mensaje]);
    }

    public function actualizarLogin(Request $request){
        Pagina::where('id', 4)->update(['mensaje_uno' => $request->mensaje_uno, 'mensaje_dos' => $request->mensaje_dos]);
    }
}
