@extends('layouts.app')

@section('content')
    <section class="sec-padding-login">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    {!! $pagina->contenido !!}
                </div>
            </div>
            @if($pagina->video_url != null)
                <div class="row">
                    <div class="col-md-12">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe width="auto" height="auto" src="{{ asset('storage/' . $pagina->video_url) }}" frameborder="0" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <sliders-ubicacion :ubicacion="3"></sliders-ubicacion>
@endsection