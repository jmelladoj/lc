<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {!! SEO::generate(true) !!}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"></link>
    <link href="{{ asset('css/pagina-css.css') }}" rel="stylesheet">

    <link rel="icon" type="image/png" href="{{ asset('storage/general/favicon.png') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
</head>
<body>
    <div id="app">
        <div class="site-wrapper">
            <header id="header" class="header-nav" data-header-hover="true">
                <nav id="navigation" class="header-nav">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="site-logo">
                                <a href="{{ url('/') }}">
                                    <img src="{{ asset('storage/general/logo.png') }}" class="logo-light" alt="Logo - Prebención LebenCo." />
                                    <img src="{{ asset('storage/general/logo.png') }}" class="logo-dark" alt="Logo - Prebención LebenCo." />
                                </a>
                            </div>

                            <div class="nav-menu">
                                <ul>
                                    <li class="nav-menu-item">@if(request()->is('/')) <a href="#inicio" class="{{ (request()->is('/')) ? 'sale-color' : '' }}">Bienvenido</a> @else <a href="{{ url('/#inicio') }}">Bienvenido</a> @endif</li>
                                    <li class="nav-menu-item"><a href="{{ url('/comunidad') }}" class="{{ (request()->is('comunidad')) ? 'sale-color' : '' }}">Comunidad LebenCo.</a></li>
                                    <li class="nav-menu-item"><a href="{{ url('/servicios') }}" class="{{ (request()->is('servicios')) ? 'sale-color' : '' }}">Nuestros Servicios</a></li>
                                    <li class="nav-menu-item"><a href="{{ url('/contacto') }}" class="{{ (request()->is('contacto')) ? 'sale-color' : '' }}">Contáctanos</a></li>
                                    <li class="nav-menu-item">
                                        <div class="row">
                                            <a target="_blank" href="{{ url('https://www.youtube.com/channel/UC78DsrgVX7KslItHoTuw8uQ?view_as=subscriber') }}" class="sale-color h2 ml-4 mr-2 d-none"> <img src="{{ asset('intranet/img_mail/youtube.png') }}" class="mb-1" height="30" width="auto" alt=""></a>
                                            <a target="_blank" href="{{ url('https://www.facebook.com/prevencion.lebenco.3') }}" class="sale-color h2  ml-2 mr-2 d-none"><i class="fa fa-facebook"></i></a>
                                            <a target="_blank" href="{{ url('https://www.instagram.com/prevencionlebenco.cl/?hl=es-la') }}" class="sale-color h2  ml-4 mr-2"><i class="fa fa-instagram"></i></a>
                                            <a target="_blank" href="{{ url('https://www.linkedin.com/in/prevenci%C3%B3n-lebenco-62b632184/') }}" class="sale-color h2  ml-2 mr-2 d-none"><i class="fa fa-linkedin"></i></a>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div class="nav-icons">
                                <ul>
                                    <li class="nav-icon-item d-lg-none">
                                        <div class="nav-icon-trigger menu-mobile-btn" title="Menú de navegación"><span><i class="fa fa-list"></i></span></div>
                                    </li>
                                    <li class="nav-icon-item ">
                                        <a href="{{ url('/login') }}" class="nav-icon-trigger" title="Ingresar">
                                            <span>
                                                @if(Auth::check())
                                                    <a href="{{ url('/login') }}" class="btn btn-success btn-circle white mt-3">{{ Auth::user()->nombre[0] }}</a>
                                                @else
                                                    Ingresar
                                                @endif
                                            </span>
                                        </a>
                                    </li>
                                    @auth
                                        <li class="nav-icon-item">
                                            <a class="nav-link  waves-effect waves-light" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                                <img src="{{ asset('img/salir.png') }}" height="40" class="mt-3">
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf
                                                </form>
                                            </a>
                                        </li>
                                    @endauth
                                </ul>
                            </div>

                        </div>
                    </div>
                </nav>
            </header>

            <div class="page-container">
                @yield('content')
            </div>

            @if(request()->is('/'))
                <slider-footer></slider-footer>
            @endif

            {{-- <footer class="{{ request()->is('login') || request()->is('servicios') ? 'footer-absolute bg--dark' : 'footer bg--dark' }}"> --}}
            <footer class="footer bg--dark">
                @if(!request()->is('login') && !request()->is('contacto'))
                    <section class="footer-widget-area">
                        <div class="container">
                            <div class="row text-dark">
                                <div class="footer-widget col-lg-2 col-12 mb-lg-0 mb-4 pr-lg-4">
                                    <div class="col-sm-12 col-md-12 col-lg-12 text-center">
                                        <img class="footer-logo mb-4" src="{{ asset('storage/general/logo_footer.png') }}" alt="LebenCO">
                                    </div>
                                </div>
                                <div class="footer-widget col-sm-4 col-md-2 col-lg-2 col-12 mb-lg-0 mb-4 text-center justify-content-center align-self-center">
                                    <h6 class="footer-widget-title"><a href="{{ url('/comunidad') }}" class="{{ (request()->is('comunidad')) ? 'sale-color' : 'text-dark' }}" style="opacity: 1;">Comunidad LebenCo.</a></h6>
                                </div>
                                <div class="footer-widget col-sm-4 col-md-2 col-lg-2 col-12 mb-lg-0 mb-4 text-center justify-content-center align-self-center">
                                    <h6 class="footer-widget-title"><a href="{{ url('/servicios') }}" class="{{ (request()->is('servicios')) ? 'sale-color' : 'text-dark' }}" style="opacity: 1;">Nuestros Servicios</a></h6>
                                </div>
                                <div class="footer-widget col-sm-4 col-md-2 col-lg-2 col-12 mb-lg-0 mb-4 text-center justify-content-center align-self-center">
                                    <boton-trabaja></boton-trabaja>
                                </div>
                                <div class="footer-widget col-sm-4 col-md-2 col-lg-2 col-12 mb-lg-0 mb-4 text-center justify-content-center align-self-center">
                                    <h6 class="footer-widget-title"><a href="{{ url('/contacto') }}" class="text-dark" style="opacity: 1;">Contáctanos</a></h6>
                                </div>
                                <div class="footer-widget col-sm-4 col-md-2 col-lg-2 col-12 mb-lg-0 mb-4 text-center justify-content-center align-self-center">
                                    <h6 class="footer-widget-title"><a href="{{ url('/politicas') }}" class="text-dark" style="opacity: 1;">Nuestras Políticas</a></h6>
                                </div>
                            </div>
                        </div>
                    </section>
                @endif

                <section class="footer-bottom-area">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 text-center text-md-center">
                                <p class="footer-copyright text-dark"><!--El tamaño de tu voluntad, te llevará a la siguiente meta, ¡éxito! <br> --> © 2019 Diseñado por <a href="{{ url('/#intro') }} "> Prevención LebenCo. SpA </a> - Desarrollado por <a href="https://atupy.cl/sitio/" target="_blank">Atupy</a></p>
                            </div>
                        </div>
                    </div>
                </section>
            </footer>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/pagina-js.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"></script>
</body>
</html>
