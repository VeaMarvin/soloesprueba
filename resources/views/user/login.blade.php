@extends('layouts.master')

@section('title','Inicio de Sesión')

@section('content')
<section>{{--form--}}
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                @include('partials.notificaciones')
            </div>
        </div>
        <div class="row">
            <div class="col-ms-12 text-center">
                <h2>BIENVENIDO</h2>
                <br><br>
            </div>
        </div>
        <div class="row">
            <div class="clearfix"></div>
            <div class="col-sm-4 col-sm-offset-1">
                <div class="login-form">{{--login--}}
                    <h2>Inicia Sesión</h2>
                    {!! Form::open(['route' => 'user.postlogin', 'method' => 'POST']) !!}
                        <input type="email" value="comprar@pagina.com" placeholder="Email" name="email" />
                        <input type="password" value="123456" placeholder="Password" name="password" />
                        <span><input type="checkbox" class="form-checkbox" name="remember_me" value="true">Mantenerme conectado</span>
                        <button type="submit" class="btn btn-default" name="buttonlogin" value="login">Login</button>
                    {!! Form::close() !!}
                </div>{{--./login--}}
            </div>
            <div class="col-sm-1">
                <h2 class="or">O</h2>
            </div>
            <div class="col-sm-4">
                <div class="signup-form">{{--Registrar--}}
                    <h2>¡Registrate en nuestra página web!</h2>
                    {!! Form::open(['route' => 'user.create', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                        <input type="text" class="textbox" placeholder="Nombre Completo" name="name"/>
                        <input type="email" class="textbox" placeholder="Email" name="email"/>
                        {{ Form::password('password', ['placeholder' => 'Password', 'class' => 'textbox']) }}
                        <div style="height: 230px; border: solid;" id="imagePreview"></div>
                        <div class="form-group">
                            <label style="font-size:24px;" for="input-avatar">{{ __('Click para subir imagen') }}</label>
                            <input  class="textbox" type="file" onchange="return fileValidation()" name="avatar" id="input-avatar">
                        </div>
                        <input type="text" class="textbox" placeholder="Usuario" name="nickname"/>
                        <button type="submit" class="btn btn-default" name="buttonlogin" value="registrar">Registrar</button>
                    {!! Form::close() !!}
                </div>{{--./Registrar--}}
            </div>
            <div class="col-sm-12">
                <br><br>
                <h2><strong>Concepto de e-commerce: qué es</strong></h2>
                <p>El e-commerce o comercio electrónico,
                <p><strong>Un</strong>&nbsp;<strong>sistema de compra y venta de productos y servicios que utiliza Internet como medio principal de intercambio</strong>.</p>
                <p>En otras palabras, se trata de un comercio que gestiona los cobros y pagos a través de medios electrónicos.</p>
                <br><br><br><br><br><br><br>
            </div>
        </div>
    </div>
</section>{{--./form--}}



  <script>
    function fileValidation(){
        var fileInput = document.getElementById('input-avatar');
        var filePath = fileInput.value;
        var allowedExtensions = /(.jpg|.jpeg|.png)$/i;
        if(!allowedExtensions.exec(filePath))
        {
            Swal.fire({
              type: 'error',
              title: 'Oops...',
              text: 'Solo se permiten imagenes en formato .jpeg/.jpg/.png',
            })
            fileInput.value = '';
            return false;
        }else{
            //Image preview
            if (fileInput.files && fileInput.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagePreview').innerHTML = '<img width="100%" height="100%" src="'+e.target.result+'"/>';
                };
                reader.readAsDataURL(fileInput.files[0]);
            }
        }
    }
  </script>
@endsection
