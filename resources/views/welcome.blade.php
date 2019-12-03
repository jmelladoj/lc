@extends('layouts.app')

@section('content')

    <sliders-home @auth :usuario="{{ json_encode(Auth::user()) }}" @endauth ></sliders-home>

    <categorias-home></categorias-home>

    <sliders-ubicacion :ubicacion="1" @auth :usuario="{{ json_encode(Auth::user()) }}" @endauth></sliders-ubicacion>

    <documentos-tipo :tipo="1" :titulo="'Documentos preferidos por la comunidad'" @if(Auth::check()) :autenticado="1" @else :autenticado="0" @endif></documentos-tipo>

    <sliders-ubicacion :ubicacion="2" @auth :usuario="{{ json_encode(Auth::user()) }}" @endauth></sliders-ubicacion>

    <documentos-tipo :tipo="1" :titulo="'Documentos nuevos'" @if(Auth::check()) :autenticado="1" @else :autenticado="0" @endif></documentos-tipo>
@endsection