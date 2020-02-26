@extends('layouts.app')

@section('content')
    @if($cantidad_servicios > 0)
        <section class="breadcrumb">
            <div class="breadcrumb-content">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="breadcrumb-title">Nuestros Servicios</h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <pagina-servicios></pagina-servicios>
    @endif

    <sliders-ubicacion :ubicacion="6" @auth :usuario="{{ json_encode(Auth::user()) }}" @endauth></sliders-ubicacion>
@endsection
