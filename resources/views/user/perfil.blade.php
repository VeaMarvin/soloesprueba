@extends('layouts.master')
@section('title','Perfil del usuario')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            @include('partials.notificaciones')
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-sm-12">
            <div class="card hovercard">
                <div class="card-background">
                    <img class="card-bkimg" alt="" src="{{ asset('images/shop/advertisement.jpg') }}">
                </div>
                <div class="useravatar">
                    <img alt="" src="{{Auth::user()->avatar}}">
                </div>
                <div class="card-info">
                    <span class="card-title">{{Auth::user()->name}}</span>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-sm-12">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">NIT</th>
                            <th class="text-center">Cliente</th>
                            <th class="text-center">Dirección</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Detalle</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pedidos as $pedido)
                            <tr>
                                <td class="text-center">{{ $pedido->id }}</td>
                                <td class="text-center">{{ $pedido->nit }}</td>
                                <td class="text-left">{{ $pedido->name_complete }}</td>
                                <td class="text-left">{{ $pedido->direction }}</td>
                                <td class="text-right"><strong>{{ $pedido->getStringTotalAttribute() }}</strong></td>
                                <td class="text-center">{{ $pedido->getStringFechaAttribute() }}</td>
                                <td class="text-center"><span class="{{ 'label label-'.$pedido->getStringColorAttribute() }}">{{ $pedido->status }}</span></td>
                                <td class="text-center"><a href="{{route('user.detalle_pedido',['numero' => $pedido->id])}}" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <ul class="pagination text-center">
                {{ $pedidos->links() }}
            </ul>
        </div>
    </div>
</div>
@endsection
