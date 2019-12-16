<?php

namespace App\Http\Controllers;

use App\CategoriaDocumento;
use App\Mail\Contacto;
use App\Notifications\Alerta;
use App\Pagina;
use App\General;
use App\Servicio;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PaginaController extends Controller
{
    //
    public function index_intranet($ubicacion){
        $redireccion = $ubicacion;
        $mensaje = 'sin mensaje';
        return view('home')->with(compact('redireccion', 'mensaje'));
    }

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

    public function indexHomeContacto(){
        return view('contacto');
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
        $pagina = General::find(1);
        return view('politicas')->with(compact('pagina'));
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
        } else {
            $pagina->video_url = $request->link;
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

    public function alerta(Request $request){
        $usuario = User::find(1);
        $usuario->notify(new Alerta($request->mensaje, Auth::user(), 'fa fa-exclamation-circle', 1));
    }

    public function contacto(Request $request){

        if(Auth::check()){
            $user = Auth::user();
        } else {
            $user = new User();
            $user->nombre = $request->nombre;
            $user->email = $request->email;
            $user->telefono = $request->telefono;
            $user->tipo_persona = $request->tipo_persona;
        }

        if(! Mail::to('contacto@prevencionlebenco.cl')->send(new Contacto($request->nombre, $request->asunto, $request->email, $request->telefono, $request->mensaje, $request->tipo_persona)) && ! Mail::to($request->email)->send(new Contacto($request->nombre, $request->asunto, $request->email, $request->telefono, $request->mensaje, $request->tipo_persona))){
            return ['mensaje' => 'Mensaje enviado!, pronto tomaremos contacto contigo.', 'clase' => 'success'];
        } else {
            return ['mensaje' => 'Hemos tenido inconvenientes al enviar tu correo. Por favor intenta nuevamente!', 'clase' => 'error'];
        }

        $usuario = User::find(1);
        $usuario->notify(new Alerta('Contacto', Auth::user(), 'fa fa-envelope', 2));
    }
}
