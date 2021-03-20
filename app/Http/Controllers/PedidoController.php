<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Order;
use App\Credit;
use App\Detail;
use App\Product;
use Stripe\Stripe;
use App\DiscountRate;
use App\RequestCredit;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PedidoRequest;
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
        if (!Session::has('cart'))
            return redirect()->route('carrito.index');

        $oldCart = Session::get('cart');
        if (count($oldCart->productos) === 0) {
            $notificacion = array(
                'message' => "No hay información para registrar el pedido.",
                'alert-type' => 'error'
            );

            return redirect()->route('consulta.index')->with($notificacion);
        }

        $credito = Credit::where('user_id', Auth::user()->id)->where('current', true)->where('approved', 'SI')->first();
        $carro = new Cart($oldCart);

        $carrito = $carro->productos;
        $total = "Q " . number_format($carro->total, 2, '.', ',');

        return view('shop.pedido', compact('carrito', 'total', 'credito'));
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
        try {
            if (!Session::has('cart'))
                return redirect()->route('carrito.index');

            $oldCart = Session::get('cart');
            $carro = new Cart($oldCart);

            if (empty($carro->productos)) {
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
            $data['type_payment'] = '';
            $data['sold'] = false;

            $nuevo_pedido = Order::create($data);

            foreach ($carro->productos as $articulo) {

                $producto = Product::find($articulo['codigo']);
                $cantidad = $articulo['cantidad'];
                $price = $producto->price;
                $discount = $producto->discount;

                if ($producto->offer) {
                    $multiplicar_dividir_porcentaje = round(($price * $discount) / 100, 2);
                    $restar_descuento = $price - $multiplicar_dividir_porcentaje;
                } else {
                    $restar_descuento = $price;
                }

                $nuevo_precio = round($restar_descuento, 2);
                $subtotal = $cantidad * $nuevo_precio;

                if (($producto->stock - $cantidad) < 0) {
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

            $credit = Credit::where('user_id', Auth::user()->id)->where('current', true)->where('approved', 'SI')->first();

            if (!is_null($credit) && $request->has('credit_id')) {
                $nuevo_pedido->type_payment = Order::CREDITO;
                $nuevo_pedido->save();

                $discount_rate = DiscountRate::find($credit->discount_rate_id);

                switch ($discount_rate->day_month) {
                    case DiscountRate::DIA:
                        $sumar = 'days';
                        break;

                    case DiscountRate::MES:
                        $sumar = 'month';
                        break;
                }

                $request_credit = new RequestCredit();
                $request_credit->date_start = date('Y-m-d', strtotime($nuevo_pedido->created_at));
                $request_credit->date_end = date("Y-m-d", strtotime("{$request_credit->date_start} + {$discount_rate->quantity} {$sumar}"));
                $request_credit->order_id = $nuevo_pedido->id;
                $request_credit->credit_id = $credit->id;
                $request_credit->user_id = $nuevo_pedido->user_id;
                $request_credit->total = $nuevo_pedido->total;
                $request_credit->payment = false;
                $request_credit->current = false;
                $request_credit->save();
            } else {
                $nuevo_pedido->type_payment = Order::CONTADO;
                $nuevo_pedido->save();
            }

            /*Stripe::charges()->create([
                'amount' => $nuevo_pedido->total,
                'currency' => 'Q',
                'source' => $request->stripeToken,
                'description' => 'Compra',
                'receipt_email' => $request->email
            ]);*/

            DB::commit();

            Session::forget('cart');
            $notificacion = array(
                'message' => 'Su compra ha sido realizada, el número de pedido es ' . $nuevo_pedido->id,
                'alert-type' => 'success'
            );

            return redirect()->route('user.perfil')->with($notificacion);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('pedido.index')->with('error', $e->getMessage());
        }
    }
}
