@extends('layouts.master')
@section('title', 'Empresa')

@section('content')

<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="jumbotron text-center">
                    <div class="row">
                        <div class="col-md-12">
                            <img class="img-thumbnail" style="margin-left: auto; margin-right: auto; display: block;" src="{!! $empresa->logotipo !!}" width="20%" height="20%" alt="logotipo">
                        </div>
                        <div class="col-md-12">
                            <h2>{{ $empresa->name }}</h2>
                        </div>
                        <div class="col-md-12">
                            <h2>{{ $empresa->slogan }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <h1>Visión</h1>
                <blockquote class="blockquote">
                  <p class="text-center">{{ $empresa->vision }}</p>
                </blockquote>
            </div>
            <div class="col-sm-6">
                <h1>Misión</h1>
                <blockquote class="blockquote">
                  <p class="text-center">{{ $empresa->mision }}</p>
                </blockquote>
            </div>
            <div class="col-sm-12">
                <br><br><br><br><br><br>
            </div>
        </div>
    </div>
</section>

@endsection
