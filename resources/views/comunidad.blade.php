@extends('layouts.app')

@section('content')
    <sliders-ubicacion :ubicacion="5" @auth :usuario="{{ json_encode(Auth::user()) }}" @endauth></sliders-ubicacion>

    @if($cantidad_vip > 0)
        <titulo-pagina titulo="Nuestra comunidad te recomienda"></titulo-pagina>

        <section class="sec-padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 mb-5 text-justify">
                        <font size="4">
                            {{ $pagina->mensaje_uno }}
                        </font>
                    </div>
                    <div class="col-md-12">
                        @guest
                            <top-five :tipo="2" :logeado="0"></top-five>
                        @else
                            <top-five :tipo="2" :logeado="1"></top-five>
                        @endguest

                    </div>
                </div>
            </div>
        </section>
    @endif
    <sliders-comunidad-pyme  @auth :tipo_persona="{{ Auth::user()->tipo_persona }}" :tipo_usuario="{{ Auth::user()->tipo_usuario }}" @endauth></sliders-comunidad-pyme>

    @if($cantidad_comunidad > 0)
        <titulo-pagina titulo="Conoce a nuestra comunidad"></titulo-pagina>

        <section class="sec-padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 mb-5 text-justify">
                        <font size="4">
                            {{ $pagina->mensaje_dos }}
                        </font>
                    </div>
                    <div class="col-md-12">
                        @guest
                            <comunidad-tabla :tipo="1" :logeado="0"></comunidad-tabla>
                        @else
                            <comunidad-tabla :tipo="1" :logeado="1"></comunidad-tabla>
                        @endguest
                    </div>
                </div>
            </div>
        </section>
    @endif

@endsection
