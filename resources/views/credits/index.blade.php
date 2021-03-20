@extends('layouts.master')
@section('title', 'Listado de créditos')

@section('content')

<section>
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            @include('partials.notificaciones')
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="signup-form">
                <h2>Listado de créditos realizados</h2>
        </div>
    </div>
    <br><br>
    <div class="row">
        <div class="col-lg-12 col-sm-12">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center">Pedido</th>
                            <th class="text-center">Crédito</th>
                            <th class="text-center">Fecha de compra</th>
                            <th class="text-center">Fecha para pagar</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Pagado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($creditos_realizados as $item)
                            <tr>
                                <td class="text-center">
                                    <a href="{{route('user.detalle_pedido',['numero' => $item->order_id])}}" class="btn btn-sm btn-info">{{ $item->getOrderConcatAttribute() }}</a>
                                </td>
                                <td class="text-center">{{ $item->credit->getCreditConcatAttribute() }}</td>
                                <td class="text-center">{{ date('d-m-Y', strtotime($item->date_start)) }}</td>
                                <td class="text-center">{{ date('d-m-Y', strtotime($item->date_end)) }}</td>
                                <td class="text-right">{{ $item->getTotalConcatAttribute() }}</td>
                                <td class="text-center">
                                    @if ($item->payment)
                                        SI
                                    @else
                                        <a href="{{route('credito.pagar',['credito' => $item->id])}}" class="btn btn-sm btn-success">Pagar</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <ul class="pagination text-center">
                {{ $creditos_realizados->links() }}
            </ul>
        </div>
    </div>
    <br><br><br>
</div>

</section>



@endsection
