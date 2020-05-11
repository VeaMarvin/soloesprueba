@extends('layouts.master')
@section('title', 'Carro de pedido')

@section('content')
    <section id="cart_items">{{--Breadcumbs y Tabla--}}
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{route('consulta.index')}}">Inicio</a></li>
				  <li class="active">Carro de pedido</li>
				</ol>
            </div>
            <h2 class="title text-center">Formulario para realizar el pedido</h2>
            <div class="well well-lg" style="background: #fe980f;">
                <div class="row">
                    {!! Form::open(['route' => 'pedido.realizar', 'method' => 'POST']) !!}

                    <div class="col-sm-12">
                        <div class="shopper-info">
                            <p>Informacion del pedido</p>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="shopper-info">
                            <input class="textbox" placeholder="NIT" type="text" name="nit" value="{{ old('nit') }}">
                        </div>
                    </div>
                    <div class="col-sm-10">
                        <div class="shopper-info">
                            <input class="textbox" placeholder="Cliente" type="text" name="name_complete" value="{{ old('name_complete') }}">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="shopper-info">
                            <input class="textbox" placeholder="Dirección" type="text" name="direction" value="{{ old('direction') }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="shopper-info">
                            <input class="textbox" placeholder="Correo electrónico" type="email" name="email" value="{{ old('email') }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="shopper-info">
                            <input class="textbox" placeholder="Teléfono" type="text" name="phone" value="{{ old('phone') }}">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="message_nuevo">
                            <textarea class="textbox" placeholder="Observación" type="text" name="observation" value="{{ old('observation') }}"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-12 ">
                        <button type="submit" class="btn btn-md btn-success pull-right">Realizar pedido ahora</button>
                    </div>
                </div>
            </div>
			@include('partials.detalle_pedido')
		</div>
	</section>{{--./Breadcumbs y Tabla--}}

	<section id="do_action">
		<div class="container">
			<div class="row">
				<div class="col-sm-6">
				</div>
				<div class="col-sm-6">
					<div class="total_area">
						<ul>
							<li class="text-right">Total <h1 style="color: black;"><strong>{{ $total }}</strong></h1></li>
                        </ul>
                        @if(empty($carrito))
                            <a class="btn btn-default btn-block check_out" href="{{route('pedido.index')}}">Confirmar pedido</a>
                    @endif
					</div>
				</div>
			</div>
		</div>
	</section><!--/#do_action-->
@endsection
