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

    <link rel="icon" type="image/png" href="{{ asset('images/Favicon.png') }}">
</head>
<body>
    <div id="app">
        <div class="site-wrapper">
            <header id="header" @if(request()->is('/')) class="header header--dark header--sticky" @else class="header header--sticky header-hover" @endif data-header-hover="true">
                <nav id="navigation" class="header-nav">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="site-logo">
                                <a href="{{ url('/') }}">
                                    <img src="{{ asset('images/logo.png') }}" class="logo-light" alt="Logo - Vitrina Laboral" />
                                    <img src="{{ asset('images/logo.png') }}" class="logo-dark" alt="Logo - Vitrina Laboral" />
                                </a>
                            </div>
                            
                            <div class="nav-menu">
                                <ul>
                                    <li class="nav-menu-item">
                                        <a href="#">INICIO</a>
                                    </li>
                                    <li class="nav-menu-item">
                                        <a href="#">MEJOR VALORADOS</a>
                                    </li>
                                    <li class="nav-menu-item"><a href="#">TARIFAS</a></li>
                                </ul>
                            </div>

                            <div class="nav-icons">
                                <ul>
                                    <li class="nav-icon-item">                           
                                        <a href="{{ url('/login') }}" class="nav-icon-trigger" title="User Account"><span><i class="ti-user"></i> @if(Auth::check())  {{ Auth::user()->nombre }} @else Ingresar @endif </span></a>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </nav>
            </header>

            <div class="page-contaiter">
                @yield('content')
            </div>


            <footer class="footer bg--dark">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center text-md-center">
                            <p class="footer-copyright text-dark">La comunidad LebenCo. agradece tu confianza. ¡Súmate! <br> <a href="https://www.youtube.com/channel/UC78DsrgVX7KslItHoTuw8uQ?view_as=subscriber" target="_blank">© 2019 Prevención LebenCo.</a>, Desarrollado por <a href="https://atupy.cl/sitio/" target="_blank">Atupy</a></p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/pagina-js.js') }}"></script>
    
</body>
</html>
