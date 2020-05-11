<div class="category-tab">

    @foreach($categorias->reverse()->take(2) as $categoria)
        <div class="well well-lg" style="background: #f0f0e9;">
            <h1 class="text-center">{{ $categoria->name }} <span class="badge">{{ $categorias->reverse()->take(2)->count() }} sub categorías</span></h1>
            <div class="row">
                @foreach($categoria->sub_categories->reverse()->take(2) as $sub_categoria)
                    <div class="col-sm-12">
                        <h3>{{$sub_categoria->name}} <span class="badge">{{ $sub_categoria->products->take(8)->count() }} productos</span></h3>
                    </div>
                    @foreach($sub_categoria->products->take(8) as $producto)
                        <div class="col-sm-3">
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

                                        <!-- Aquí va el botón -->
                                        <a href="{{route('carrito.agregar_inmediatamente',['producto' => $producto->id])}}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Añadir al carro</a>

                                    </div>
                                </div>
                                <div class="choose">
                                    <a href="{{route('consulta.detalle',['producto' => $producto->id])}}" class="btn btn-info btn-block">Ver detalle</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <hr>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
