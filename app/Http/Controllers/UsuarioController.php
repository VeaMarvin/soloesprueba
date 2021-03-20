<?php

namespace App\Http\Controllers;

use App\Company;
use App\Credit;
use App\Detail;
use App\User;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UsuarioRequest;
use App\Order;
use App\RequestCredit;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Barryvdh\DomPDF\Facade as PDF;

class UsuarioController extends Controller
{
    /*
        Descripción: función que muestra la pantalla de inicio de sesión.
        Page: resources/views/user/login
        Route name: user.login
        Route URL: /login
        Paramétros:
        Modelos:
        Retorna:
    */
    public function login()
    {
        return view('user.login');
    }

    /*
        Descripción: función para inicio de sesión.
        Page: resources/views/user/login
        Route name: user.postlogin
        Route URL: /postlogin
        Paramétros: $request
        Modelos:
        Retorna: $notificacion
    */
    public function postlogin(LoginRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember_me))
        {
            //Verificamos si el usuario se encuentra activo, si en caso no estuviera activo lo mandos al login.
            if(is_null(User::where('email', $request->email)->where('current', true)->first()))
            {
                Auth::logout();
                $notificacion = array(
                    'message' => 'El usuario se encuentra inactivo, comunicarse con soporte técnico.',
                    'alert-type' => 'info'
                );

                return Redirect::route('user.login')
                                ->with($notificacion);
            }

            //Si el usuario inicia sesión guardamos datos para la compra del carrito
            if(Session::has('oldUrl'))
            {
                $oldUrl = Session::get('oldUrl');
                Session::forget('oldUrl');
                return Redirect::to($oldUrl);
            }

            return Redirect::route('consulta.index');
        }
        else
        {
            //Si los datos del usuarios no son correctos
            $notificacion = array(
                'message' => 'Usuario o contraseña incorrectos',
                'alert-type' => 'error'
            );

            return Redirect::route('user.login')
                            ->with($notificacion);
        }
    }

    /*
        Descripción: función para crear usuario.
        Page: resources/views/user/login
        Route name: user.create
        Route URL: /create
        Paramétros: $request
        Modelos: User
        Retorna: $notificacion
    */
    public function create(UsuarioRequest $request)
    {
        $data = $request->all();

        if(!empty($request->avatar))
        {
            $img_data = file_get_contents($request->file('avatar'));
            $base64 = base64_encode($img_data);
            $data['avatar'] = $base64;
        }

        $nuevousuario = User::create($data);
        $nuevousuario->save();

        $notificacion = array(
                    'message' => 'Usuario registrado correctamente, inicie sesión',
                    'alert-type' => 'success'
                );

        if(Session::has('oldUrl'))
        {
            $oldUrl = Session::get('oldUrl');
            Session::forget('oldUrl');
            return Redirect::to($oldUrl)->with($notificacion);
        }

        return Redirect::back()->with($notificacion);
    }

    /*
        Descripción: función para mostrar la información del usuario logueado en la página.
        Page: resources/views/user/perfil
        Route name: user.perfil
        Route URL: /perfil
        Paramétros:
        Modelos: User
        Retorna: $pedidos
    */
    public function perfil()
    {
        $pedidos = Order::where('user_id', Auth::user()->id)->orderBy('id','DESC')->paginate(10);

        return view('user.perfil', compact('pedidos'));
    }

    /*
        Descripción: función para mostrar la información del pedido seleccionado.
        Page: resources/views/user/detalle_pedido
        Route name: user.detalle_pedido
        Route URL: /perfil/pedido/{numero}/detalle
        Paramétros: $numero
        Modelos: Order, Detail
        Retorna: $pedido, $detalles
    */
    public function detalle_pedido($numero)
    {
        $pedido = Order::find($numero);
        $detalles = Detail::where('order_id', $pedido->id)->get();
        return view('user.detalle_pedido', compact('pedido','detalles'));
    }

    /*
        Descripción: función para terminar la sesión del usuario.
        Page: resources/views/shop/index
        Route name: user.logout
        Route URL: /logout
        Paramétros:
        Modelos:
        Retorna:
    */
    public function logout()
    {
        Auth::logout();
        return Redirect::route('consulta.index');
    }

    public function pdf($numero)
    {
        $tipo_credito = null;
        $pedido = Order::find($numero);
        $detalles = Detail::where('order_id', $pedido->id)->get();
        if($pedido->status == Order::CREDITO)
        {
            $credito = RequestCredit::where('order_id', $pedido->id)->first();
            $tipo_credito = Credit::find($credito->credit_id);
        }
        $company = Company::find(1);

        $pdf = PDF::loadView('pdf.factura', compact('pedido','detalles','company','credito','tipo_credito'));
        return $pdf->stream('factura.pdf');
    }
}
