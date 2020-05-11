@extends('layouts.master')
@section('title', 'Detalle del Pedido')

@section('content')
    <section id="cart_items">{{--Breadcumbs y Tabla--}}
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li class="pull-right"><a href="{{route('user.perfil')}}">Regresar al listado de pedidos</a></li>
				</ol>
            </div>
            <h2>Detalle del Pedido #<strong>{{ $pedido->id }}</strong></h2>
            <div class="row">
                <div class="col-sm-12">
                    <div class="shopper-info">
                        <p>Informacion del pedido</p>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="shopper-info">
                        <input type="text" disabled value="{{ $pedido->nit }}">
                    </div>
                </div>
                <div class="col-sm-10">
                    <div class="shopper-info">
                        <input type="text" disabled value="{{ $pedido->name_complete }}">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="shopper-info">
                        <input type="text" disabled value="{{ $pedido->direction }}">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="shopper-info">
                        <input type="text" disabled value="{{ $pedido->email }}">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="shopper-info">
                        <input type="text" disabled value="{{ $pedido->phone }}">
                    </div>
                </div>
                <div class="col-sm-4 text-center" style="align-items: center; justify-content: center; display: flex;">
                    <span class="{{ 'label label-'.$pedido->getStringColorAttribute() }}" style="font-size: 26px;">{{ $pedido->status }}</span>
                </div>
                <div class="col-sm-12">
                    <div class="message_nuevo">
                        <textarea disabled>{{ $pedido->observation }}</textarea>
                    </div>
                </div>
            </div>
            <div class="table-responsive cart_info">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-center">Producto</th>
                            <th class="text-center">Precio</th>
                            <th class="text-center">Descuento</th>
                            <th class="text-center">Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detalles as $key => $detalle)
                            <tr>
                                <td class="text-center">{{ $key++ }}</td>
                                <td class="text-center">{{ $detalle->quantity }}</td>
                                <td class="text-left">{{ $detalle->product }}</td>
                                <td class="text-right">{{ $detalle->price }}</td>
                                <td class="text-right">{{ $detalle->getStringDiscountAttribute() }}</td>
                                <td class="text-right"><strong>{{ $detalle->getStringSubTotalAttribute() }}</strong></td>                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
		</div>
	</section>{{--./Breadcumbs y Tabla--}}

	<section id="do_action">
		<div class="container">
			<div class="heading">
				<h3>Datos del pedido</h3>
				<p>En este apartada se detalle el total a cancelar del pedido #<strong>{{ $pedido->id }}</strong>.</p>
			</div>
			<div class="row">
				<div class="col-sm-6">
				</div>
				<div class="col-sm-6">
					<div class="total_area">
						<ul>
							<li class="text-right">Total <h1 style="color: black;"><strong>{{ $pedido->getStringTotalAttribute() }}</strong></h1></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section><!--/#do_action-->
@endsection
