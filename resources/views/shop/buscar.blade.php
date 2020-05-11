@extends('layouts.master')
@section('title', 'Busqueda')

@section('content')

<section>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            @if ($productos->count() > 0)
                @foreach ($productos as $producto)
                    <div class="media">
                        <div class="media-left media-middle">
                            @if($producto->images->count() > 0)
                                @foreach($producto->images->take(1) as $imagen)
                                    <img class="media-object" style="width:100px;height:100px;" src="{{$imagen->photo}}" alt="{{ $imagen->id }}" />
                                @endforeach
                            @else
                                <img class="media-object" style="width:100px;height:100px;" src="data:image/jpeg;base64,iVBORw0KGgoAAAANSUhEUgAAAFgAAABYBAMAAACDuy0HAAAAG1BMVEXMzMyWlpbFxcWjo6OxsbG+vr6qqqq3t7ecnJwRtUHbAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAAdklEQVRIiWNgGAWjYBSMglEwCkYBGUBZWMnQCMZUACJ8ik1UjJ2cYUwDIMKnWIhJUEGRgcGN3QDIFAAiIkzW0FAgwuRAwVBBUQYGljYQMwCIiDCZSZQEN7MZM5Di5gAiTIaGcwowNAiH8ygYBaNgFIyCUTAYAQBzNRHuWxEUOAAAAABJRU5ErkJggg==" alt="photo">
                            @endif
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">{{$producto->title}}</h4>
                            <p>{{$producto->description}}</p>
                            <p>
                                <a href="{{route('consulta.detalle',['producto' => $producto->id])}}" class="btn btn-info">
                                    Ver detalle
                                </a>
                            </p>
                        </div>
                    </div>
                @endforeach
                <div style="margin-top:20px" >
                    <ul class="pagination">
                        {{$productos->links()}}
                    </ul>
                </div>
            @else
                <div class="alert alert-danger">
                    <strong>¡Mensaje!</strong> no se encontro información.
                </div>
            @endif
            <br><br>
        </div>
    </div>
</div>

</section>



@endsection
