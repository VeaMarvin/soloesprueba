<div class="table-responsive cart_info">
    <table class="table">
        <thead>
            <tr class="cart_menu">
                <th class="text-center">Producto</th>
                <th class="text-center">Información</th>
                <th class="text-center">Cantidad</th>
                <th class="text-center">Precio Q</th>
                <th class="text-center">Descuento</th>
                <th class="text-center">Sub Total Q</th>
                <th class="text-center"></th>
            </tr>
        </thead>
        <tbody>
            @if(Session::has('cart'))
                @forelse ($carrito as $item)
                    <tr>
                        <td class="text-center">
                            <img src="{{ $item['foto'] }}" alt="{{ $item['codigo'] }}" style="height:110px;width:110px;">
                        </td>
                        <td class="text-left">
                            <a href="{{route('consulta.detalle',['producto' => $item['codigo']])}}" style="font-size: 14px:">{{ $item['producto'] }}</a>
                            <p>Código: {{ $item['codigo'] }}</p>
                        </td>
                        <td class="text-center">
                            <div class="cart_quantity_button">
                                <a class="cart_quantity_up" href="{{route('carrito.agregar_inmediatamente', ['producto' => $item['codigo']])}}"> + </a>
                                <input class="cart_quantity_input" type="text" name="quantity" value="{{ $item['cantidad'] }}" autocomplete="off" size="2" disabled>
                                <a class="cart_quantity_down" href="{{route('carrito.eliminar_cantidad', ['producto' => $item['codigo']])}}"> - </a>
                            </div>
                        </td>
                        <td class="text-right">{{$item['precio']}}</td>
                        <td class="text-right">{{$item['descuento']}}</td>
                        <td class="text-right">{{$item['subtotal']}}</td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-danger" href="{{route('carrito.eliminar', ['producto' => $item['codigo']])}}"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="alert alert-danger">
                                <strong>¡Mensaje!</strong> el carrito no tiene productos.
                            </div>
                        </td>
                    </tr>
                @endforelse
            @else
                <tr>
                   <td colspan="6">
                        <div class="alert alert-danger">
                            <strong>¡Mensaje!</strong> usted no ha iniciado una compra.
                        </div>
                   </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
