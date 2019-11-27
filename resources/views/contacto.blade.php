@extends('layouts.app')

@section('content')

    <contacto @auth :user="{{ json_encode(Auth::user()) }}" @endauth></contacto>

    <sliders-ubicacion :ubicacion="4"></sliders-ubicacion>

@endsection
