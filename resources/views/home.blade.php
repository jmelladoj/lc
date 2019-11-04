@extends('layouts.intranet')

@section('content')
    @if(Auth::user()->tipo_usuario == 1)
        @include('menu.admin')
    @elseif(Auth::user()->tipo_usuario == 2)
        @include('menu.admin')
    @elseif(Auth::user()->tipo_usuario == 3)
        @include('menu.usuario')
    @endif
@endsection