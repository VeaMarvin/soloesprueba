@extends('layouts.master')

@section('title')
	{{$producto->title}}
@endsection

@section('content')
<section>
		<div class="container">
			<div class="row">
				@include('partials.leftsidebar')

				<div class="col-sm-9 padding-right">
					<div class="product-details">{{--Producto--}}
                        <div class="well well-lg"  style="background: #f0f0e9;">
                            <div class="row">
                                <div class="col-sm-5">
                                    <div id="cambiar_principal" class="view-product">{{--Imagen destacada--}}
                                        @if($producto->images->count() > 0)
                                            @foreach($producto->images->take(1) as $imagen)
                                                <img id="image_zoom" class="lazyload" data-src="{{ $imagen->photo }}" alt="{{ $producto->title }}" />
                                            @endforeach
                                        @else
                                            <img id="image_zoom" class="lazyload" data-src="data:image/jpeg;base64,iVBORw0KGgoAAAANSUhEUgAAAFgAAABYBAMAAACDuy0HAAAAG1BMVEXMzMyWlpbFxcWjo6OxsbG+vr6qqqq3t7ecnJwRtUHbAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAAdklEQVRIiWNgGAWjYBSMglEwCkYBGUBZWMnQCMZUACJ8ik1UjJ2cYUwDIMKnWIhJUEGRgcGN3QDIFAAiIkzW0FAgwuRAwVBBUQYGljYQMwCIiDCZSZQEN7MZM5Di5gAiTIaGcwowNAiH8ygYBaNgFIyCUTAYAQBzNRHuWxEUOAAAAABJRU5ErkJggg==" alt="photo">
                                        @endif
                                    </div>{{--./Imagen destacada--}}
                                    <div id="similar-product" class="carousel slide" data-ride="carousel">{{--Carousel Imagenes--}}
                                            <div class="carousel-inner">
                                                @foreach($producto->images->chunk(3) as $bloque_images)
                                                    <div class="item {{$loop->first ? 'active' : ''}}">
                                                        @foreach($bloque_images as $imagen)
                                                            <img data-src="{{ $imagen->photo }}" alt="{{ $producto->title }}" class="cambiar_imagen lazyload img-responsive" style="height:84px;width:71px">
                                                        @endforeach
                                                    </div>
                                                @endforeach
                                            </div>
                                          {{--Controles--}}
                                          <a class="left item-control" href="#similar-product" data-slide="prev">
                                            <i class="fa fa-angle-left"></i>
                                          </a>
                                          <a class="right item-control" href="#similar-product" data-slide="next">
                                            <i class="fa fa-angle-right"></i>
                                          </a>
                                    </div>{{--./Carousel Imagenes--}}

                                </div>
                                <div class="col-sm-7">
                                    <div class="product-information">{{--Informacion Producto--}}
                                        @if($producto->new_product)
                                            <span class="label label-success newarrival">{{ $producto->getStringNewProductAttribute() }}</span>
                                        @endif

                                        @if($producto->offer)
                                            <span class="label label-info newarrival">{{ $producto->getStringDiscountAttribute() }}</span>
                                        @endif

                                        <h2>{{$producto->title}}</h2>
                                        <p>Código: {{$producto->id}}</p>
                                        <img src="{{ asset('images/product-details/rating.png') }}" alt="rating" />
                                        <span>
                                            <span>Precio: {{$producto->getStringPriceAttribute()}}</span>

                                            {!!Form::open(['route'=>'carrito.agregar_mas','method'=>'POST'])!!}
                                            {!!Form::hidden('product_id',$producto->id)!!}
                                            {!!Form::label('Cantidad:')!!}
                                            {!!Form::text('quantity',1)!!}
                                            {!!Form::button('<i class="fa fa-shopping-cart"></i> Añadir al carro',[
                                                'class' => 'btn btn-default cart',
                                                'type' => 'submit'
                                            ])!!}
                                            {!!Form::close()!!}

                                        </span>

                                        <p><b>Disponibilidad:</b> {{$producto->getStringStockAttribute()}}</p>
                                        <p><b>Stock:</b> {{$producto->stock}}</p>
                                        <p><b>Marca:</b> {{$producto->getBrandAttribute()}}</p>

                                        <a href=""><img src="{{ asset('images/product-details/share.png') }}" class="share img-responsive"  alt="share" /></a>
                                    </div>{{--./Informacion Producto--}}
                                </div>
                            </div>{{--./Producto--}}
                        </div>
                    </div>

                    <div class="well well-lg">
                        <ul class="nav nav-tabs nav-justified">
                            <li class="active"><a href="#description" data-toggle="tab">Descripción</a></li>
                            <li><a href="#comments" data-toggle="tab">{{ 'Comentarios ('.$producto->product_comments->count().')' }}</a></li>
                        </ul>

                        <div class="tab-content">
                            <div id="description" class="tab-pane fade in active">
                                <br>
                                <p class="text-justify">{{$producto->description}}</p>
                            </div>
                            <div id="comments" class="tab-pane fade">
                                <h2>Comentar respecto al producto {{$producto->title}}</h2>
                                <div class="signup-form">
                                    <h2>Comentar respecto al producto {{$producto->title}}</h2>
                                    {!! Form::open(['route' => 'comentario_producto.nuevo', 'method' => 'POST']) !!}
                                        <input type="hidden" name="product_id" value="{{ $producto->id }}">
                                        <textarea class="textbox" name="comment"></textarea>
                                        <button type="submit" class="btn btn-default pull-right" value="registrar">Comentar</button>
                                    {!! Form::close() !!}
                                </div>
                                <br><br>
                                <hr>
                                @foreach ($producto->product_comments->reverse()->take(10) as $comentario)
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">
                                                {{ $comentario->getUserAttribute().' - '.$comentario->getStringFechaAttribute() }}
                                                @if (Auth::check())
                                                    @if ($comentario->user_id == Auth::user()->id)
                                                        <a href="{{route('comentario_producto.eliminar',['id' => $comentario->id])}}" class="btn btn-danger btn-xs pull-right">X</a>
                                                    @endif
                                                @endif
                                            </h3>
                                        </div>
                                        <div class="panel-body">{{ $comentario->comment }}</div>
                                    </div>
                                @endforeach
                                <hr>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</section>
@endsection
