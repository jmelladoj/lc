@extends('layouts.app')

@section('content')

    <busqueda :categoria="{{ json_encode($categoria) }}" @if(Auth::check()) :autenticado="1" @else :autenticado="0" @endif></busqueda>

@endsection