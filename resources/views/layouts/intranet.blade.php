<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {!! SEO::generate(true) !!}

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">

    <link rel="icon" type="image/png" href="{{ asset('storage/general/favicon.png') }}">

</head>
<body class="fixed-layout skin-green">
    <div id="app">
        <div id="main-wrapper">
            <header class="topbar">
                <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="{{ url('/') }}">
                            <b>
                                <img src={{ asset('storage/general/logo_escritorio.png') }} alt="homepage" class="dark-logo" height="50">
                            </b>
                        </a>
                    </div>

                    <div class="navbar-collapse">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item"> <a class="nav-link nav-toggler d-block d-sm-none waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                            <li class="nav-item"> <a class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark" href="javascript:void(0)"><i class="icon-menu"></i></a> </li>
                            <busqueda-documento></busqueda-documento>
                        </ul>

                        <ul class="navbar-nav my-lg-0">
                            <li class="nav-item right-side-toggle btn-success">
                                <a class="nav-link dropdown-toggle waves-effect waves-dark" aria-expanded="false">
                                    <input type="hidden" id="saldo_usuario" name="saldo_usuario" value="{{ Auth::user()->saldo }}">
                                    <i class="fa fa-usd"></i>
                                    <span class="hide-menu" id="saldo" name="saldo">
                                        {{ Auth::user()->saldo }}
                                    </span>
                                </a>
                            </li>
                            @if(Auth::user()->tipo_usuario < 3)
                                <notificaciones></notificaciones>
                            @endif
                            @if(Auth::user()->tipo_usuario < 3)<li class="nav-item right-side-toggle" @click="ubicacion=0"> <a class="nav-link dropdown-toggle waves-effect waves-dark" aria-expanded="false"><i class="fa fa-file-text"></i><span class="hide-menu"> Home</span></a></li>@endif
                            @if(Auth::user()->tipo_usuario == 3)<li class="nav-item right-side-toggle"> <a class="nav-link dropdown-toggle waves-effect waves-dark" href="{{ url('/') }}" aria-expanded="false"><i class="fa fa-file-text"></i><span class="hide-menu"> Home</span></a></li>@endif
                            <li class="nav-item right-side-toggle" @click="ubicacion=1"> <a class="nav-link dropdown-toggle waves-effect waves-dark" aria-expanded="false"><i class="fa fa-home"></i><span class="hide-menu"> Escritorio</span></a></li>
                            <li class="nav-item right-side-toggle"> <a class="nav-link  waves-effect waves-light" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><img src="{{ asset('img/salir.png') }}" height="40px" width="40px"><form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form></a></li>
                        </ul>
                    </div>
                </nav>
            </header>

            @yield('content')

            <footer class="footer text-center">
                © 2018 <a href="https://www.youtube.com/channel/UC78DsrgVX7KslItHoTuw8uQ?view_as=subscriber" target="_blank" onmouseover="this.style.color = '#8AB733'" onmouseout="this.style.color = '#1e2f13'"> Prevención LebenCo. IS Online</a>. Todos los derechos reservados.
            </footer>

        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/admin.js') }}"></script>

    <script>
        $(document).ready(function() {
            var redireccion = $('#redireccion').val()

            if(redireccion){
                $('#accion').click()
            }
        });
    </script>

</body>
</html>
