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
                            {{ $item['producto'] }}
                            <p>Código: {{ $item['codigo'] }}</p>
                        </td>
                        <td class="text-center"><h4>{{ $item['cantidad'] }}</h4></td>
                        <td class="text-right">{{$item['precio']}}</td>
                        <td class="text-right">{{$item['descuento']}}</td>
                        <td class="text-right">{{$item['subtotal']}}</td>
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
