<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\InvitacionUsuario;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username(){
        return 'run';
    }

    public function authenticated(){
        Auth::user()->update([
            'last_login_at' => Carbon::now()->toDateTimeString(),
        ]);

        $invitaciones = InvitacionUsuario::where('user_id', Auth::user()->id)->where('pagada', 0)->get();

        foreach($invitaciones as $item){
            $user = User::where('email', $item->correo_invitado)->whereNotNull('last_login_at')->first();

            if(!$user){
                $item->pagada = 1;
                $item->save();

                Auth::user()->saldo += $item->recompensa;
                Auth::user()->save();
            }
        }

    }

    public function showLoginForm(Request  $request){
        if ($request->has('redirect_to')) {
            session()->put('redirect_to', $request->input('redirect_to'));
        }

        return view('auth.login');
    }

    public function redirectTo(){
        if (session()->has('redirect_to'))
            return session()->pull('redirect_to');

        return $this->redirectTo;
    }
}
