@extends('layouts.master')

@section('title',$nombre_sub_categoria)

@section('content')
<section>
    <div class="container">
        <div class="row">
            @include('partials.leftsidebar')

            <div class="col-sm-9 padding-right">
                <h2 class="title text-center">{{$nombre_sub_categoria}}</h2>
                <div class="features_items"  style="background: #f0f0e9;"><!--features_items-->
                    <button type="button" class="btn btn-primary pull-right">
                        Página
                        <span class="badge badge-light">{{ number_format($productos->currentPage(),0,'',',') }}</span>
                        de
                        <span class="badge badge-light">{{ number_format($productos->perPage(),0,'',',') }}</span>
                        productos, mostrados
                        <span class="badge badge-light">{{ number_format($productos->perPage() * $productos->currentPage(),0,'',',') }}</span>
                        de un total de
                        <span class="badge badge-light">{{ number_format($productos->total(),0,'',',') }}</span>
                        productos
                    </button>
                    <br><br><hr>

                    @include('partials.productos')

                    <ul class="pagination">
                        {{ $productos->links() }}
                    </ul>
                </div><!--features_items-->
            </div>
            <div class="col-sm-12">
                <br><br><br><br>
            </div>
        </div>
    </div>
</section>
@endsection
