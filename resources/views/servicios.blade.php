@extends('layouts.app')

@section('content')
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

    <section class="sec-padding-login">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p>
                        {{ $pagina->mensaje_uno }}
                    </p>
                </div>
            </div>
            @if(count($servicios) > 0)
                <div class="row">
                    @foreach ($servicios as $item)

                        <div class="col-md-6 col-lg-4">
                                <!--Blog Item-->
                            <div class="blog-item">
                                <div class="blog-item-content">
                                    <h4 class="blog-title"><a href="#">{{ $item->nombre }}</a></h4>
                                    <div class="blog-description-content">
                                        <p>
                                            {{ $item->descripcion }}
                                        </p>
                                    </div>
                                    <div class="text-center">
                                        <img  src="{{ asset('storage/' . $item->imagen_url) }}" class="img-fluid" height="80"/>
                                    </div>
                                </div>
                            </div>
                            <!--End Blog Item-->
                        </div>

                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <sliders-ubicacion :ubicacion="6"></sliders-ubicacion>
@endsection