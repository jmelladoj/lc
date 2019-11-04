<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;

class NotificacionController extends Controller
{
    //
    public function index(){      
        return ['notificaciones' => Auth::user()->unreadNotifications];
    }

    public function leer(Request $request){
        DatabaseNotification::find($request->id)->markAsRead();
    }
}
