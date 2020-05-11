@extends('layouts.master')
@section('title', 'Comentarios')

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
                <h2>Comentar respecto a la página</h2>
                {!! Form::open(['route' => 'comentario_general.nuevo', 'method' => 'POST']) !!}
                    <textarea class="textbox" name="comment"></textarea>
                    <button type="submit" class="btn btn-default pull-right" value="registrar">Comentar</button>
                {!! Form::close() !!}
            </div>
            <br><br>
            <hr>
            @foreach ($comentarios as $comentario)
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            {{ $comentario->getUserAttribute().' - '.$comentario->getStringFechaAttribute() }}
                            @if (Auth::check())
                                @if ($comentario->user_id == Auth::user()->id)
                                    <a href="{{route('comentario_general.eliminar',['id' => $comentario->id])}}" class="btn btn-danger btn-xs pull-right">X</a>
                                @endif
                            @endif
                        </h3>
                    </div>
                    <div class="panel-body">{{ $comentario->comment }}</div>
                </div>
            @endforeach
            <ul class="pagination">
                {{ $comentarios->links() }}
            </ul>
        </div>
    </div>
</div>

</section>



@endsection
