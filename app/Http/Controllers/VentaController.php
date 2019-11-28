<?php

namespace App\Http\Controllers;

use App\CategoriaUsuario;
use App\User;
use App\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Freshwork\Transbank\CertificationBagFactory;
use Freshwork\Transbank\TransbankServiceFactory;
use Freshwork\Transbank\RedirectorHelper;

class VentaController extends Controller
{
    //
    public function index($tipo){      
        switch ($tipo) {
            case 1:
                return ['recargas' => Venta::orderBy('created_at', 'desc')->get()];
                break;
            case 2:
                return ['recargas' => Venta::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get()];
                break;
        }
    }

    public function recargar(Request $request){
        $ventas = Venta::get()->count();

        $bag = CertificationBagFactory::integrationWebpayNormal();
        $plus = TransbankServiceFactory::normal($bag);
        $plus->addTransactionDetail($request->monto, ($ventas + 1)); // Monto e identificador de la orden
        

        $response = $plus->initTransaction(url('/venta/procesar'), url('/venta/finalizar'));

        $venta = Venta::create([
            'token' => $response->token,
            'monto_venta' => $request->monto,
            'monto_recarga' => $request->monto,
            'estado' => 1,
            'monto_bonificacion' => 0,
            'user_id' => Auth::id()
        ]);
        
        return [
            'url' => $response->url,
            'token' => $response->token
        ];
    }

    public function procesar(Request $request){
        $bag = CertificationBagFactory::integrationWebpayNormal();
        $plus = TransbankServiceFactory::normal($bag);
        $response = $plus->getTransactionResult();

        if($response->detailOutput->responseCode == 0){
            $venta = Venta::where('token', $request->token_ws)->first();
            $venta->estado = 2;
            $venta->save();

            $user = User::find(Auth::id());
            $user->saldo += $venta->monto_recarga;
            $user->save();      
        }

        $plus->acknowledgeTransaction();
        return RedirectorHelper::redirectBackNormal($response->urlRedirection);
        
    }

    public function finalizar(Request $request){
        $venta = Venta::where('token', $request->token_ws)->first();

        $mensaje = "La carga no se ha podido realizar. Por favor intente nuevamente.";

        if($venta != null){
            $mensaje = "Muchas gracias por recarga, tu saldo ya ha sido cargado.";
            $total = Venta::where('user_id', Auth::id())->get()->sum('monto_venta');
            $categoria = CategoriaUsuario::where('gasto_inicio','>=', $total)->where('gasto_fin', '<=', $total)->first();
            
            if($categoria){
                if(Auth::user()->categorias_usuarios_id != $categoria->id){
                    $mensaje = "Muchas gracias por recarga, tu saldo ya ha sido cargado y has sudibo a la siguiente categoría:" . $categoria->nombre . ", sigue así para seguir desbloqueando nuevas funciones.";
                }
            }
            
        }

        return view('home')->with(compact('mensaje'));
    }
}
