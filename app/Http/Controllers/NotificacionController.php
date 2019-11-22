<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;

class NotificacionController extends Controller
{
    //
    public function index($tipo){      
        switch ($tipo) {
            case 1:
                return ['alertas' => User::find(1)->unreadNotifications];
            case 2:
                echo "i es igual a 1";
                break;
            case 3:
                echo "i es igual a 2";
                break;
        }
        
    }

    public function leer(Request $request){
        DatabaseNotification::find($request->id)->markAsRead();
    }
}
