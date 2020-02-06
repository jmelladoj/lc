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
        $descripcion = "";

        switch($ubicacion){
            case 1:
                $descripcion = "Slider perfil";
                break;
            case 2:
                $descripcion = "Slider pide documento";
                break;
            case 3:
                $descripcion = "Slider sorteos";
                break;
            case 4:
                $descripcion = "Slider promociones";
                break;
            case 6:
                $descripcion = "Slider seminarios";
                break;
            case 7:
                $descripcion = "Slider terreno";
                break;
            case 8:
                $descripcion = "Slider recomiéndanos";
                break;
            case 11:
                $descripcion = "Slider subir documento";
                break;
            case 12:
                $descripcion = "Slider recargar";
                break;
        }


        if(Auth::check()){
            $usuario = Auth::user();

            $user = User::find(1);
            $user->notify(new Alerta($descripcion, $usuario, "", 'fa fa-picture-o', 2));

            return view('home')->with(compact('redireccion', 'mensaje'));
        } else {
            return view('auth.login')->with(compact('redireccion', 'mensaje'));
        }

    }

    public function indexHomeNosotros(){
        $pagina = Pagina::find(1);

        return view('nosotros')->with(compact('pagina'));
    }

    public function indexHomeComunidad(){
        $pagina = Pagina::find(2);
        $cantidad_vip = User::where('top_five', 1)->get()->count();
        $cantidad_comunidad = User::where('comunidad_pyme', 1)->get()->count();

        return view('comunidad')->with(compact('pagina', 'cantidad_vip', 'cantidad_comunidad'));
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
        return ['contenido' => Pagina::find(1)];
    }

    public function indexServicios(Request $request)
    {
        return ['pagina' => Pagina::find(3)];
    }

    public function index_home_usuario(Request $request)
    {
        return ['pagina' => Pagina::find(5)];
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
            $pagina->video_titulo = $request->file('video')->getClientOriginalName();
            $video = $request->file('video');
            $nombre = 'video_nosotros.' . $request->file('video')->getClientOriginalExtension();

            if($pagina->video_url != null) { Storage::disk('public')->delete($pagina->video_url); }

            $pagina->video_url = Storage::disk('public')->putFileAs(
                'general', $video, $nombre, 'public'
            );
        } else {
            $pagina->video_url = $request->link;
            $pagina->video_titulo = $request->link;
        }

        if($request->contenido != null || $request->contenido != ''){
            $pagina->contenido = $request->contenido;
        }

        $pagina->save();

    }

    public function actualizar_home_usuario(Request $request){
        $pagina = Pagina::find(5);
        $pagina->contenido =  $request->contenido;

        if ($request->hasFile('imagen')) {
            if($pagina->video_url != null) { Storage::disk('public')->delete($pagina->video_url); }

            $pagina->video_url = Storage::disk('public')->putFile('general', $request->file('imagen'));
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
        $usuario->notify(new Alerta($request->mensaje, Auth::user(), "", 'fa fa-exclamation-circle', 1));
    }

    public function contacto(Request $request){

        $email = "";

        if(Auth::check()){
            $user = Auth::user();
            $email = $user->email;
        } else {
            $user = [
                'nombre' => $request->nombre,
                'email' => $request->email,
                'telefono' => $request->telefono,
                'tipo_persona' => $request->tipo_persona
            ];

            $email = $request->email;
        }

        if(!Mail::to('contacto@prevencionlebenco.cl')->send(new Contacto($request->nombre, $request->asunto, $email, $request->telefono, $request->mensaje, $request->tipo_persona))){
            $usuario = User::find(1);
            $usuario->notify(new Alerta('Contacto', $user, "", 'fa fa-envelope', 9));

            return ['mensaje' => 'Mensaje enviado!, pronto tomaremos contacto contigo.', 'clase' => 'success'];
        } else {
            return ['mensaje' => 'Hemos tenido inconvenientes al enviar tu correo. Por favor intenta nuevamente!', 'clase' => 'error'];
        }
    }

    public function eliminar_video(){
        $pagina = Pagina::find(1);

        if($pagina->video_url != null) { Storage::disk('public')->delete($pagina->video_url); }

        $pagina->video_url = null;
        $pagina->video_titulo = 'Sin vídeo.';
        $pagina->save();
    }
}
