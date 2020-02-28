@extends('layouts.app')

@section('content')
    <section class="sec-padding">
        <div class="container">
            {{-- <politicas></politicas> --}}
            <div class="row">
                <div class="col-md-12">
                    @isset($pagina)
                        {!! $pagina->terminos_url !!}
                    @endisset
                </div>
            </div>
        </div>
    </section>
@endsection
