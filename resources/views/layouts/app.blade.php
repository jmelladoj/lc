<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {!! SEO::generate(true) !!}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/pagina-css.css') }}" rel="stylesheet">

    <link rel="icon" type="image/png" href="{{ asset('storage/general/favicon.png') }}">

    <link rel="stylesheet" href="{{ url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css') }}">
</head>
<body>
    <div id="app">
        <footer class="site-wrapper">
            <header id="header" @if(request()->is('/')) class="header header--dark header--sticky" @else class="header header--sticky header-hover" @endif data-header-hover="true">
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
                                    <li class="nav-menu-item">@if(request()->is('/')) <a href="#inicio" class="{{ (request()->is('/')) ? 'sale-color' : '' }}">Inicio</a> @else <a href="{{ url('/#inicio') }}">Inicio</a> @endif</li>
                                    <li class="nav-menu-item"><a href="{{ url('/nosotros') }}" class="{{ (request()->is('nosotros')) ? 'sale-color' : '' }}">Comunidad LebenCo.</a></li>
                                    <li class="nav-menu-item"><a href="{{ url('/comunidad') }}" class="{{ (request()->is('comunidad')) ? 'sale-color' : '' }}">Comunidad Pyme</a></li>
                                    <li class="nav-menu-item"><a href="{{ url('/servicios') }}" class="{{ (request()->is('servicios')) ? 'sale-color' : '' }}">Nuestros Servicios</a></li>
                                    <li class="nav-menu-item"><a href="{{ url('https://www.youtube.com/channel/UC78DsrgVX7KslItHoTuw8uQ?view_as=subscriber') }}" class="sale-color h2"><i class="fa fa-youtube"></i></a></li>
                                    <li class="nav-menu-item"><a href="{{ url('https://www.facebook.com/prevencion.lebenco.3') }}" class="sale-color h2"><i class="fa fa-facebook"></i></a></li>
                                    <li class="nav-menu-item"><a href="{{ url('https://www.instagram.com/prevencionlebenco.cl/?hl=es-la') }}" class="sale-color h2"><i class="fa fa-instagram"></i></a></li>
                                    <li class="nav-menu-item"><a href="{{ url('https://www.linkedin.com/in/prevenci%C3%B3n-lebenco-62b632184/') }}" class="sale-color h2"><i class="fa fa-linkedin"></i></a></li>
                                </ul>
                            </div>

                            <div class="nav-icons">
                                <ul>
                                    <li class="nav-icon-item">                           
                                        <a href="{{ url('/login') }}" class="nav-icon-trigger" title="Ingresar"><span><i class="fa fa-user sale-color"></i> @if(Auth::check())  {{ Auth::user()->nombre }} @else Ingresar @endif </span></a>
                                    </li>
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
            <footer class="footer bg--dark">
                <section class="footer-widget-area">
                    <div class="container">
                        <div class="row text-dark">
                            <div class="col-md-4">
                                <div class="col-sm-12 col-md-12 col-lg-12 mb-lg-0 mb-4 text-center">
                                    <img src="{{ asset('storage/general/logo_footer.png') }}" class="footer-logo mb-4" alt="LebenCO" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="footer-widget col-sm-12 col-md-12 col-lg-12 mb-lg-0 mb-4 text-center">
                                    <h6 class="footer-widget-title"><a href="{{ url('/nosotros') }}" class="{{ (request()->is('nosotros')) ? 'sale-color' : 'text-dark' }}" style="opacity: 1;">Comunidad LebenCo.</a></h6>
                                </div>
                                <div class="footer-widget col-sm-12 col-md-12 col-lg-12 mb-lg-0 mb-4 text-center">
                                    <h6 class="footer-widget-title"><a href="{{ url('/servicios') }}" class="{{ (request()->is('servicios')) ? 'sale-color' : 'text-dark' }}" style="opacity: 1;">Nuestros Servicios</a></h6>
                                </div>
                                <div class="footer-widget col-sm-12 col-md-12 col-lg-12 mb-lg-0 mb-4 text-center">
                                    <h6 class="footer-widget-title"><a href="#" class="text-dark" style="opacity: 1;">Trabaja en LebenCo.</a></h6>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="footer-widget col-sm-12 col-md-12 col-lg-12 mb-lg-0 mb-4 text-center">
                                    <h6 class="footer-widget-title"><a href="{{ url('/comunidad') }}" class="{{ (request()->is('comunidad')) ? 'sale-color' : 'text-dark' }}" style="opacity: 1;">Comunidad Pyme</a></h6>
                                </div>
                                <div class="footer-widget col-sm-12 col-md-12 col-lg-12 mb-lg-0 mb-4 text-center">
                                    <h6 class="footer-widget-title"><a href="{{ url('/contacto') }}" class="text-dark" style="opacity: 1;">Contáctanos</a></h6>
                                </div>
                                <div class="footer-widget col-sm-12 col-md-12 col-lg-12 mb-lg-0 mb-4 text-center">
                                    <h6 class="footer-widget-title"><a href="{{ url('#') }}" class="text-dark" style="opacity: 1;">Nuestras Políticas</a></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
        
                <section class="footer-bottom-area">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 text-center text-md-center">
                                <p class="footer-copyright text-dark">La comunidad LebenCo. agradece tu confianza. ¡Súmate! <br> <a href="https://www.youtube.com/channel/UC78DsrgVX7KslItHoTuw8uQ?view_as=subscriber" target="_blank">© 2019 Prevención LebenCo.</a>, Desarrollado por <a href="https://atupy.cl/sitio/" target="_blank">Atupy</a></p>
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
    
</body>
</html>
