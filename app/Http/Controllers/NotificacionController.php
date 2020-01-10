<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;

class NotificacionController extends Controller
{
    //
    public function index($tipo){      
        switch ($tipo) {
            case 1:
                $lunes = Carbon::parse('monday this week')->format('Y-m-d');
                $domingo = Carbon::parse('sunday this week')->format('Y-m-d');

                $alertas = User::find(1)->unreadNotifications->reverse();
                $alertas = $alertas->merge(User::find(1)->notifications->whereBetween('created_at', [$lunes, $domingo])->reverse());           

                return ['alertas' => $alertas];
                break;
            case 2:
                return ['alertas' => User::find(1)->unreadNotifications];
            case 3: 
                $alertas = User::find(1)->unreadNotifications;
                
                $filtrados = $alertas->filter(function ($item, $key) {
                    return $item->data['tipo_notificacion'] == 9;
                });

                return ['alertas' => $filtrados];
        }
        
    }

    public function leer(Request $request){
        DatabaseNotification::find($request->id)->markAsRead();
    }
}
