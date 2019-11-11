@extends('layouts.app')

@section('content')

    <sliders-home></sliders-home>

    <categorias-home></categorias-home>

    <sliders-ubicacion :ubicacion="1"></sliders-ubicacion>

    <documentos-tipo :tipo="1" :titulo="'Documentos preferidos por la comunidad'" @if(Auth::check()) :autenticado="1" @else :autenticado="0" @endif></documentos-tipo>

    <sliders-ubicacion :ubicacion="2"></sliders-ubicacion>

    <documentos-tipo :tipo="1" :titulo="'Documentos nuevos'" @if(Auth::check()) :autenticado="1" @else :autenticado="0" @endif></documentos-tipo>
@endsection