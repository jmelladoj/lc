@extends('layouts.app')

@section('content')
    <sliders-ubicacion :ubicacion="5" @auth :usuario="{{ json_encode(Auth::user()) }}" @endauth></sliders-ubicacion>

    <section class="breadcrumb">
        <div class="breadcrumb-content">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2 class="breadcrumb-title">Top five en nuestra comunidad Pyme</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="sec-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p>
                        {{ $pagina->mensaje_uno }}
                    </p>
                    @guest
                        <top-five :tipo="1" :logeado="0"></top-five>
                    @else
                        <top-five :tipo="1" :logeado="1"></top-five>
                    @endguest
                    
                </div>
            </div>
        </div>
    </section>

    <sliders-comunidad-pyme  @auth :tipo_persona="{{ Auth::user()->tipo_persona }}" :tipo_usuario="{{ Auth::user()->tipo_usuario }}" @endauth></sliders-comunidad-pyme>

    <section class="breadcrumb">
        <div class="breadcrumb-content">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2 class="breadcrumb-title">Nuestra comunidad Pyme</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    

    <section class="sec-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p>
                        {{ $pagina->mensaje_dos }}
                    </p>
                    @guest
                        <top-five :tipo="2" :logeado="0"></top-five>
                    @else
                        <top-five :tipo="2" :logeado="1"></top-five>
                    @endguest
                </div>
            </div>
        </div>
    </section>

@endsection