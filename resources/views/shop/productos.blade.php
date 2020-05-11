@extends('layouts.master')

@section('title','Productos')

@section('content')

<section>
    <div class="container">
        <div class="row">
            @include('partials.leftsidebar')

            <div class="col-sm-9 padding-right">
                <div class="features_items"><!--features_items-->
                    <h2 class="title text-center">Productos</h2>
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
        </div>
    </div>
</section>
@endsection
