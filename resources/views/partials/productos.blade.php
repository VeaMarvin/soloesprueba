@foreach($productos->chunk(3) as $bloque_productos)
    @foreach($bloque_productos as $producto)
        <div class="col-sm-4">
            <div class="product-image-wrapper">
                <div class="single-products">
                        <div class="productinfo text-center">
                            @if($producto->images->count() > 0)
                                @foreach($producto->images->take(1) as $imagen)
                                    <img src="{{$imagen->photo}}" alt="{{ $imagen->id }}" />
                                @endforeach
                            @else
                                <img src="data:image/jpeg;base64,iVBORw0KGgoAAAANSUhEUgAAAFgAAABYBAMAAACDuy0HAAAAG1BMVEXMzMyWlpbFxcWjo6OxsbG+vr6qqqq3t7ecnJwRtUHbAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAAdklEQVRIiWNgGAWjYBSMglEwCkYBGUBZWMnQCMZUACJ8ik1UjJ2cYUwDIMKnWIhJUEGRgcGN3QDIFAAiIkzW0FAgwuRAwVBBUQYGljYQMwCIiDCZSZQEN7MZM5Di5gAiTIaGcwowNAiH8ygYBaNgFIyCUTAYAQBzNRHuWxEUOAAAAABJRU5ErkJggg==" alt="photo">
                            @endif
                            <h2>{{$producto->getStringPriceAttribute()}}</h2>
                            <p>{{$producto->title}}</p>

                            <!-- Botón que hace la magia -->
                            <a href="{{route('carrito.agregar_inmediatamente',['producto' => $producto->id])}}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Añadir al carro</a>

                        </div>
                        <div class="product-overlay">
                            <div class="overlay-content">
                                <h2>{{$producto->getStringPriceAttribute()}}</h2>
                                <p>{{$producto->description}}</p>

                                <!-- Botón que hace la magia -->
                                <a href="{{route('carrito.agregar_inmediatamente',['producto' => $producto->id])}}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Añadir al carro</a>

                            </div>

                            @if($producto->new_product)
                                <span class="label label-success pull-right">{{ $producto->getStringNewProductAttribute() }}</span>
                            @else
                                <span class="label label-warning pull-right">{{ $producto->getStringNewProductAttribute() }}</span>
                            @endif

                            @if($producto->offer)
                                <span class="label label-info pull-right">{{ $producto->getStringDiscountAttribute() }}</span>
                            @endif
                        </div>
                </div>
                <div class="choose">
                    <a href="{{route('consulta.detalle',['producto' => $producto->id])}}" class="btn btn-primary btn-block">Ver detalle</a>
                </div>
            </div>
        </div>
    @endforeach
@endforeach
