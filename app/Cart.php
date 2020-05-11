<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public $productos = array();
    public $agragados_al_carrito = 0;
    public $total = 0;

    public function __construct($oldCart)
    {
        if($oldCart)
        {
            $this->productos = $oldCart->productos;
            $this->agragados_al_carrito = $oldCart->agragados_al_carrito;
            $this->total = $oldCart->total;
        }
    }

    //Función para agregar un producto al carrito
    public function agregar_un_producto($producto, $producto_id)
    {
        $cantidad = 1;
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
        $foto = "data:image/jpeg;base64,iVBORw0KGgoAAAANSUhEUgAAAFgAAABYBAMAAACDuy0HAAAAG1BMVEXMzMyWlpbFxcWjo6OxsbG+vr6qqqq3t7ecnJwRtUHbAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAAdklEQVRIiWNgGAWjYBSMglEwCkYBGUBZWMnQCMZUACJ8ik1UjJ2cYUwDIMKnWIhJUEGRgcGN3QDIFAAiIkzW0FAgwuRAwVBBUQYGljYQMwCIiDCZSZQEN7MZM5Di5gAiTIaGcwowNAiH8ygYBaNgFIyCUTAYAQBzNRHuWxEUOAAAAABJRU5ErkJggg==";

        foreach ($producto->images->take(1) as $imagen)
        {
            $foto = $imagen->photo;
        }

        $agregar_item_al_carrito = [
            'foto' => $foto,
            'producto' => $producto->getNameCompleteAttribute(),
            'codigo' => $producto->id,
            'cantidad' => $cantidad,
            'precio' => number_format($price,2,'.',','),
            'descuento' => number_format($discount,2,'.',',')."%",
            'subtotal' => number_format($subtotal,2,'.',',')
        ];

        if(!empty($this->productos))
        {
            if(array_key_exists($producto_id, $this->productos))
            {
                $agregar_item_al_carrito['subtotal'] = 0;
                $this->total -= $this->productos[$producto_id]['cantidad']*$nuevo_precio;

                $cantidad = $this->productos[$producto_id]['cantidad'] + 1;
                $subtotal = $cantidad*$nuevo_precio;

                $agregar_item_al_carrito = $this->productos[$producto_id];
                $agregar_item_al_carrito['foto'] = $foto;
                $agregar_item_al_carrito['producto'] = $producto->getNameCompleteAttribute();
                $agregar_item_al_carrito['cantidad'] = $cantidad;
                $agregar_item_al_carrito['precio'] = number_format($price,2,'.',',');
                $agregar_item_al_carrito['descuento'] = number_format($discount,2,'.',',')."%";
                $agregar_item_al_carrito['subtotal'] = number_format($subtotal,2,'.',',');
            }
        }

        $this->productos[$producto_id] = $agregar_item_al_carrito;
        $this->agragados_al_carrito++;
        $this->total += $subtotal;
    }

    //Función para aumentar la cantidad de un producto
    public function agregar_varios_productos($producto, $nueva_cantidad, $producto_id)
    {
        $cantidad = $nueva_cantidad;
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
        $foto = "data:image/jpeg;base64,iVBORw0KGgoAAAANSUhEUgAAAFgAAABYBAMAAACDuy0HAAAAG1BMVEXMzMyWlpbFxcWjo6OxsbG+vr6qqqq3t7ecnJwRtUHbAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAAdklEQVRIiWNgGAWjYBSMglEwCkYBGUBZWMnQCMZUACJ8ik1UjJ2cYUwDIMKnWIhJUEGRgcGN3QDIFAAiIkzW0FAgwuRAwVBBUQYGljYQMwCIiDCZSZQEN7MZM5Di5gAiTIaGcwowNAiH8ygYBaNgFIyCUTAYAQBzNRHuWxEUOAAAAABJRU5ErkJggg==";

        foreach ($producto->images->take(1) as $imagen)
        {
            $foto = $imagen->photo;
        }

        $agregar_item_al_carrito = [
            'foto' => $foto,
            'producto' => $producto->getNameCompleteAttribute(),
            'codigo' => $producto->id,
            'cantidad' => $cantidad,
            'precio' => number_format($price,2,'.',','),
            'descuento' => number_format($discount,2,'.',',')."%",
            'subtotal' => number_format($subtotal,2,'.',',')
        ];

        if(!empty($this->productos))
        {
            if(array_key_exists($producto_id, $this->productos))
            {
                $cantidad = $this->productos[$producto_id]['cantidad'] + $cantidad;
                $this->agragados_al_carrito -= $this->productos[$producto_id]['cantidad'];
                $this->total -= $this->productos[$producto_id]['cantidad']*$nuevo_precio;
                $subtotal = $cantidad*$nuevo_precio;

                $agregar_item_al_carrito = $this->productos[$producto_id];
                $agregar_item_al_carrito['foto'] = $foto;
                $agregar_item_al_carrito['producto'] = $producto->getNameCompleteAttribute();
                $agregar_item_al_carrito['cantidad'] = $cantidad;
                $agregar_item_al_carrito['precio'] = number_format($price,2,'.',',');
                $agregar_item_al_carrito['descuento'] = number_format($discount,2,'.',',')."%";
                $agregar_item_al_carrito['subtotal'] = number_format($subtotal,2,'.',',');
            }
        }

        $this->productos[$producto_id] = $agregar_item_al_carrito;
        $this->agragados_al_carrito += $cantidad;
        $this->total += $subtotal;
    }

    //Función para eliminar producto del carrito
    public function eliminar_producto($producto_id)
    {
        $cantidad = $this->productos[$producto_id]['cantidad'];
        $producto = Product::find($producto_id);
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

        $this->agragados_al_carrito -= $cantidad;
        $this->total -= $subtotal;

        unset($this->productos[$producto_id]);

        if(empty($this->productos))
        {
            $this->productos = array();
            $this->agragados_al_carrito = 0;
            $this->total = 0;
        }
    }

    //Función para eliminar la cantidad de uno en uno el producto
    public function eliminar_un_producto($producto_id)
    {
        $cantidad = $this->productos[$producto_id]['cantidad'] - 1;
        $producto = Product::find($producto_id);
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

        $this->productos[$producto_id]['cantidad'] = $cantidad;
        $this->productos[$producto_id]['subtotal'] = number_format($subtotal,2,'.',',');
        $this->agragados_al_carrito -= 1;
        $this->total -= $nuevo_precio;

        if($cantidad <= 0)
        {
            unset($this->productos[$producto_id]);

            if(empty($this->productos))
            {
                $this->productos = array();
                $this->agragados_al_carrito = 0;
                $this->total = 0;
            }
        }
    }
}
