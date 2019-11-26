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
            <div class="row mb-4">
                <div class="col-md-12">
                    <p>
                        {{ $pagina->mensaje_uno }}
                    </p>
                </div>
            </div>
            @if(count($servicios) > 0)
                @foreach ($servicios as $item)
                    <div class="card mb-3">
                        <div class="row mt-0 ml-0 mr-0 mb-0">
                            <div class="col-md-2 mx-auto my-auto  mt-0 ml-0 mr-0 mb-0">
                                <div class="text-center ">
                                    <img  src="{{ asset('storage/' . $item->imagen_url) }}" height="100"/>
                                </div>
                            </div>
                            <div class="col-md-10 mx-auto my-auto  mt-0 ml-0 mr-0 mb-0">
                                <div class="blog-item mr-5">
                                    <h4 class="blog-title"><a href="javascript:void(0)">{{ $item->nombre }}</a></h4>
                                    <div class="blog-description-content">
                                        <p class="text-justify">
                                            {{ $item->descripcion }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </section>

    <sliders-ubicacion :ubicacion="6"></sliders-ubicacion>
@endsection