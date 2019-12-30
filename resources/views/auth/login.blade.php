@extends('layouts.app')

@section('content')
    @isset($redireccion)
    <li id="accion" name="accion" @click="menu={{ $redireccion }}" class="d-none"></li>
    <input type="hidden" id="redireccion" name="redireccion" value="{{ $redireccion }}">
    @endisset

    <iniciar-sesion></iniciar-sesion>
@endsection
