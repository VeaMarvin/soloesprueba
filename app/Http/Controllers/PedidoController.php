<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Detail;
use App\Order;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PedidoRequest;
use App\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PedidoController extends Controller
{
    /*
        Descripción: función que muestra la información del pedido a realizar.
        Page: resources/views/shop/pedido
        Route name: pedido.index
        Route URL: /pedido
        Paramétros: Session
        Modelos: Cart
        Retorna: $cart, $total, $formato_total
    */
    public function index()
    {
        if(!Session::has('cart'))
            return redirect()->route('carrito.index');

        $oldCart = Session::get('cart');
        if(count($oldCart->productos) === 0)
        {
            $notificacion = array(
                'message' => "No hay información para registrar el pedido.",
                'alert-type' => 'error'
            );

            return redirect()->route('consulta.index')->with($notificacion);
        }

        $carro = new Cart($oldCart);

        $carrito = $carro->productos;
        $total = "Q ".number_format($carro->total, 2, '.', ',');

        return view('shop.pedido', compact('carrito','total'));
    }

    /*
        Descripción: función para registrar el pedido.
        Page: resources/views/shop/pedido
        Route name: pedido.realizar
        Route URL: /realizar/pedido
        Paramétros: $request
        Modelos: Session, Cart, Order, Product, Detail
        Retorna: $notificacion
    */
    public function realizar(PedidoRequest $request)
    {
        try
        {
            if(!Session::has('cart'))
                return redirect()->route('carrito.index');

            $oldCart = Session::get('cart');
            $carro = new Cart($oldCart);

            if(empty($carro->productos))
            {
                $notificacion = array(
                    'message' => "No hay información para registrar el pedido.",
                    'alert-type' => 'error'
                );

                return redirect()->route('consulta.index')->with($notificacion);
            }

            DB::beginTransaction();
                $usuario = Auth::user();
                $data = $request->all();
                $data['status'] = Order::PEDIDO;
                $data['total'] = 0;
                $data['user_id'] = $usuario->id;

                $nuevo_pedido = Order::create($data);

                foreach ($carro->productos as $articulo) {

                    $producto = Product::find($articulo['codigo']);
                    $cantidad = $articulo['cantidad'];
                    $price = $producto->price;
                    $discount = $producto->discount;

                    if($producto->offer)
                    {
                        $multiplicar_dividir_porcentaje = round(($price*$discount)/100,2);
                        $restar_descuento = $price - $multiplicar_dividir_porcentaje;
                    }
                    else
                    {
                        $restar_descuento = $price;
                    }

                    $nuevo_precio = round($restar_descuento, 2);
                    $subtotal = $cantidad*$nuevo_precio;

                    if(($producto->stock - $cantidad) < 0)
                    {
                        $notificacion = array(
                            'message' => "El producto {$producto->title} no tiene suficiente stock.",
                            'alert-type' => 'warning'
                        );

                        return redirect()->route('pedido.index')->with($notificacion);
                    }

                    $detalle_pedido = new Detail();
                    $detalle_pedido->quantity = $cantidad;
                    $detalle_pedido->product = $articulo['producto'];
                    $detalle_pedido->price = $nuevo_precio;
                    $detalle_pedido->discount = $discount;
                    $detalle_pedido->subtotal = $subtotal;
                    $detalle_pedido->order_id = $nuevo_pedido->id;
                    $detalle_pedido->product_id = $producto->id;
                    $detalle_pedido->save();

                    $nuevo_pedido->total += $detalle_pedido->subtotal;
                }

                $nuevo_pedido->save();
            DB::commit();

            Session::forget('cart');
            $notificacion = array(
                'message' => 'Su compra ha sido realizada, el número de pedido es ' . $nuevo_pedido->id,
                'alert-type' => 'success'
            );

            return redirect()->route('user.perfil')->with($notificacion);
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->route('pedido.index')->with('error', $e->getMessage());
        }
    }
}
