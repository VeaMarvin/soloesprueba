<header id="header">{{--Header--}}
    <div class="header_top">{{-- Header superior --}}
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="contactinfo">
                        <ul class="nav nav-pills">
                            <li><a href="{{route('consulta.index')}}">{{ $nombre_empresa }} / {{ $slogan }}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="social-icons pull-right">
                        <ul class="nav navbar-nav">
                            <li><a class="btn btn-facebook" href="{!! $facebook !!}"><i class="fa fa-facebook"></i></a></li>
                            <li><a class="btn btn-twitter" href="{!! $twitter !!}"><i class="fa fa-twitter"></i></a></li>
                            <li><a class="btn btn-instagram" href="{!! $instagram !!}"><i class="fa fa-instagram"></i></a></li>
                            <li><a class="btn" href="{!! $page !!}"><i class="fa fa-laptop"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>{{-- ./Header superior --}}

    <div class="header-middle">{{-- Header medio --}}
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-5 col-lg-5">
                    <div class="logo pull-left">
                        <a href="{{ route('consulta.index') }}"><img class="foto_avatar" src="{!! $logotipo !!}" alt="Inicio" title="inicio" /></a>
                    </div>
                </div>
                <div class="col-sm-12 col-md-7 col-lg-7">
                    <div class="shop-menu pull-right">
                        <ul class="nav navbar-nav">
                            <li>
                                <!-- Falta agregar la ruta del carrito -->
                                <a href="{{route('carrito.index')}}">
                                    <i class="fa fa-shopping-cart"></i>
                                    Carro <span class="badge">{{Session::has('cart') ? Session::get('cart')->agragados_al_carrito : '0'}}</span>
                                </a>
                            </li>
                            @if(Auth::check())
                                <li class="dropdown">
                                    <a href="#!" class="dropdown-toggle">
                                        <span class="glyphicon glyphicon-user"></span>
                                        <strong>{{ Auth::user()->getNameCompleteAttribute() }}</strong>
                                        <span class="glyphicon glyphicon-chevron-down"></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <div class="navbar-login">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <p class="text-center">
                                                            <img class="foto_avatar" src="{!! Auth::user()->avatar !!}" alt="avatar">
                                                        </p>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <p class="text-left"><strong>{!! Auth::user()->name !!}</strong></p>
                                                        <p class="text-left small">{!! Auth::user()->email !!}</p>
                                                        <p class="text-left small">{!! Auth::user()->nickname !!}</p>
                                                        <p class="text-center">
                                                            <a href="{{route('user.perfil')}}" class="btn btn-info btn-block">Compras realizadas</a>
                                                            <a href="{{route('user.logout')}}" class="btn btn-danger btn-block">Cerrar sesión <span class="glyphicon glyphicon-log-out"></span></a>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </li>

                            @else
                                <li><a href="{{ route('user.login') }}"><i class="fa fa-lock"></i> Iniciar Sesión</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>{{-- ./Header medio --}}

    <div class="header-bottom">{{-- Header inferior --}}
        <div class="container">
            <div class="row">
                <div class="col-sm-9">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="mainmenu pull-left">
                        <ul class="nav navbar-nav collapse navbar-collapse">
                            <li><a href="{{ route('consulta.index') }}" class="{{URL::current() == URL::route('consulta.index') ? 'active' : ''}}">Inicio</a></li>
                            <li><a href="{{ route('consulta.productos') }}" class="{{URL::current() == URL::route('consulta.productos') ? 'active' : ''}}">Productos</a></li>
                            <li><a href="{{ route('consulta.empresa') }}" class="{{URL::current() == URL::route('consulta.empresa') ? 'active' : ''}}">Empresa</a></li>
                            <li><a href="{{ route('consulta.contacto') }}" class="{{URL::current() == URL::route('consulta.contacto') ? 'active' : ''}}">Contactanos</a></li>
                            <li><a href="{{ route('comentario_general.index') }}" class="{{URL::current() == URL::route('comentario_general.index') ? 'active' : ''}}">Comentarios ({{ $comentarios }})</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="search_box pull-right">
                        <form action="{{ route('consulta.buscar') }}" method="GET">
                            <input type="text" placeholder="Buscar" name="search"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>{{-- ./Header inferior --}}
</header>{{-- ./Header --}}
