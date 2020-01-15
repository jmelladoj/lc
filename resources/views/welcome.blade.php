@extends('layouts.app')

@section('content')

    <sliders-home @auth :usuario="{{ json_encode(Auth::user()) }}" @endauth ></sliders-home>

    <categorias-home></categorias-home>

    <sliders-ubicacion :ubicacion="2" @auth :usuario="{{ json_encode(Auth::user()) }}" @endauth></sliders-ubicacion>

    <documentos-tipo :tipo="1" :titulo="'Documentos nuevos'" @if(Auth::check()) :autenticado="1" @else :autenticado="0" @endif></documentos-tipo>

    <!-- 
    <documentos-tipo :tipo="1" :titulo="'Documentos preferidos por la comunidad'" @if(Auth::check()) :autenticado="1" @else :autenticado="0" @endif></documentos-tipo>

    <sliders-ubicacion :ubicacion="2" @auth :usuario="{{ json_encode(Auth::user()) }}" @endauth></sliders-ubicacion>
    -->
    <section class="sec-padding-login">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    {!! $pagina_nosotros->contenido !!}
                </div>
            </div>
            @if($pagina_nosotros->video_url != null)
                <div class="row">
                    <div class="col-md-12">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe width="auto" height="auto" @if(strpos($pagina_nosotros->video_url, 'www')) src="{{ $pagina_nosotros->video_url }}" @else src="{{ asset('storage/' . $pagina_nosotros->video_url) }}" @endif frameborder="0" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

@endsection