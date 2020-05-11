@extends('layouts.master')

@section('title','Inicio')

@section('content')
<section>
	<div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
                        <li data-target="#slider-carousel" data-slide-to="1"></li>
                        <li data-target="#slider-carousel" data-slide-to="2"></li>
                    </ol>

                    <div class="carousel-inner">
                        @forelse($ofertas as $oferta)
                                <div class="item {{ $loop->first ? 'active' : ''}}">
                                    <div class="col-sm-6">
                                        <h1><span>Ofertas</span> {{ $nombre_empresa }}</h1>
                                        <h2>{{$oferta->title}}</h2>
                                        <p>{{substr($oferta->description,0,100)}}...</p>
                                        <a href="{{route('consulta.detalle',['producto' => $oferta->id])}}" class="btn btn-default get">Ver detalle</a>
                                    </div>
                                    <div class="col-sm-6">
                                        <a href="{{route('consulta.detalle',['producto' => $oferta->id])}}" class="sello girl img-responsive">{{$oferta->getStringDiscountAttribute()}}</a>
                                    </div>
                                </div>
                            @empty
                            No hay ofertas
                        @endforelse
                    </div>

                    <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                        <i class="fa fa-angle-left"></i>
                    </a>
                    <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div>
                <br><br><hr>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                @include('partials.notificaciones')
            </div>
            <div class="col-sm-12">
                @if(Session::has('success'))
                    <div class="row">
                        <div class="col-sm-6 col-md-4 col-md-offset-4 col-sm-offset-3">
                            <div id="charge-message" class="alert alert-success">
                                {{Session::get('success')}}
                            </div>
                        </div>
                    </div>
                @endif
                <br><br>
            </div>
        </div>
        <div class="row">

            @include('partials.leftsidebar')

            <div class="col-sm-9 padding-right">
                <h2 class="title text-center">Productos agregados recientemente</h2>
                <div class="features_items" style="background: #f0f0e9;">{{-- Ultimos productos --}}
                    <br>
                    @include('partials.productos')
                </div>{{-- ./Ultimos productos --}}
            </div>

            <div class="col-sm-12">
                <br><br>
                {{-- Ultimos productos --}}
                <h2 class="title text-center">Categorías agregadas recientemente</h2>
                @include('partials.categorias')
                {{--./Pestañas Categorias--}}
                <br><br><br>
            </div>
        </div>

    </div>
</section>

@endsection
