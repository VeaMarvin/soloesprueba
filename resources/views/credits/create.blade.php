@extends('layouts.master')
@section('title', 'Crédito')

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
                <h2>Escoger el crédito al que desea aplicar</h2>
                {!! Form::open(['route' => 'credito.store', 'method' => 'POST']) !!}
                    <select name="discount_rate_id" id="discount_rate_id">
                        @foreach ($descuentos as $item)
                            <option value="{{ $item->id }}">{{ $item->getNameAttribute() }}</option>
                        @endforeach
                    </select>
                    <br><br>
                    <button type="submit" class="btn btn-default pull-right" value="registrar">Aplicar</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <br><br>
    <div class="row">
        <div class="col-lg-12 col-sm-12">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center">Respuesta</th>
                            <th class="text-center">Crédito</th>
                            <th class="text-center">Vendedor</th>
                            <th class="text-center">En uso</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($creditos as $credito)
                            <tr>
                                <td class="text-center">{{ $credito->approved }}</td>
                                <td class="text-left">{{ $credito->getCreditConcatAttribute() }}</td>
                                <td class="text-left">{{ $credito->getEmpleadoAttribute() }}</td>
                                <td class="text-center">
                                    @if ($credito->current)
                                        SI
                                    @else
                                        NO
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <ul class="pagination text-center">
                {{ $creditos->links() }}
            </ul>
        </div>
    </div>
    <br><br><br>
</div>

</section>



@endsection
