<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Language" content="es">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Página WEB | @yield('title')</title>
    @include('partials.styles')
    @yield('styles')
    @yield('extra-css')
</head>
<body onload="init();">
    @include('partials.header')
    @yield('content')
    @include('partials.footer')
    @include('partials.scripts')
    @yield('scripts')
</body>
</html>
