<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Http\Requests\AgregarMasRequest;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CarritoController extends Controller
{
    /*
        Descripción: función que muestra la información del carrito en sesión.
        Page: resources/views/shop/carrito
        Route name: carrito.index
        Route URL: /carrito
        Paramétros: Session
        Modelos: Cart
        Retorna: $carro, $productos, $totalPrecio
    */
    public function index()
    {
        $carrito = null;
        $total = null;

        if(!Session::has('cart'))
            return view('shop.carrito', compact('carrito','total'));

        $oldCart = Session::get('cart');
        $carro = new Cart($oldCart);
        $carrito = $carro->productos;
        $total = "Q ".number_format($carro->total, 2, '.', ',');

        return view('shop.carrito', compact('carrito','total'));
    }

    /*
        Descripción: función que agrega el producto al carrito.
        Page:
        Route name: carrito.agregar_inmediatamente
        Route URL: /agregar/inmediatamente/{producto}
        Paramétros: $request, $producto
        Modelos: Product, Cart
        Retorna: $notificacion
    */
    public function agregar_inmediatamente(Request $request, Product $producto)
    {
        try {

            $oldCart = Session::has('cart') ? Session::get('cart') : null;
            $carro = new Cart($oldCart);
            $carro->agregar_un_producto($producto, $producto->id);

            $request->session()->put('cart', $carro);

            $notificacion = array(
                'message' => "El producto {$producto->title}, fue agragado al carrito con cantidad 1.",
                'alert-type' => 'success'
            );

            return redirect()->back()->with($notificacion);

        }
        catch(\Exception $e)
        {
            $notificacion = array(
                'message' => "El producto {$producto->title}, no fue agregado.",
                'alert-type' => 'info'
            );

            return redirect()->back()->with($notificacion);
        }
    }

    /*
        Descripción: función que aumenta la cantidad de producto.
        Page:
        Route name: carrito.agregar_mas
        Route URL: /agregar/mas
        Paramétros: $request
        Modelos: Product, Cart
        Retorna: $notificacion
    */
    public function agregar_mas(AgregarMasRequest $request)
    {
        try {

            $producto = Product::find($request->product_id);
            $oldCart = Session::has('cart') ? Session::get('cart') : null;
            $carro = new Cart($oldCart);
            $carro->agregar_varios_productos($producto, $request->quantity, $producto->id);

            $request->session()->put('cart', $carro);

            $notificacion = array(
                'message' => "La cantidad de {$request->quantity} fueron agregadas al producto {$producto->title}.",
                'alert-type' => 'success'
            );

            return redirect()->back()->with($notificacion);
        }
        catch(\Exception $e)
        {
            $notificacion = array(
                'message' => "La cantidad de {$request->quantity} no fueron agregadas al producto {$producto->title}.",
                'alert-type' => 'info'
            );

            return redirect()->back()->with($notificacion);
        }
    }

    /*
        Descripción: función que eliminar el producto al carrito.
        Page:
        Route name: carrito.eliminar
        Route URL: /eliminar/{producto}
        Paramétros: $producto
        Modelos: Product, Cart
        Retorna: $notificacion
    */
    public function eliminar(Product $producto)
    {
        try {
            $oldCart = Session::has('cart') ? Session::get('cart') : null;
            $carro = new Cart($oldCart);
            $carro->eliminar_producto($producto->id);

            count($carro->productos) > 0 ? Session::put('cart', $carro) : Session::forget('cart');

            Session::put('cart', $carro);

            $notificacion = array(
                'message' => "El producto {$producto->title} fue eliminado del carrito.",
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notificacion);
        }
        catch(\Exception $e)
        {
            $notificacion = array(
                'message' => "El producto {$producto->title} no fue eliminado del carrito.",
                'alert-type' => 'info'
            );

            return redirect()->back()->with($notificacion);
        }
    }

    /*
        Descripción: función que resta la cantidad de producto.
        Page:
        Route name: carrito.eliminar_cantidad
        Route URL: /eliminar/cantidad/{producto}
        Paramétros: $producto
        Modelos: Product, Cart
        Retorna: $notificacion
    */
    public function eliminar_cantidad(Product $producto)
    {
        try {
            $oldCart = Session::has('cart') ? Session::get('cart') : null;
            $carro = new Cart($oldCart);
            $carro->eliminar_un_producto($producto->id);

            Session::put('cart', $carro);

            $notificacion = array(
                'message' => "Al producto {$producto->title} se le resto una unidad en el carrito.",
                'alert-type' => 'warning'
            );

            return redirect()->back()->with($notificacion);
        }
        catch(\Exception $e)
        {
            $notificacion = array(
                'message' => $e->getMessage(),
                'alert-type' => 'info'
            );

            return redirect()->back()->with($notificacion);
        }
    }
}
