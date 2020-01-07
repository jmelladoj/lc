@extends('layouts.intranet')

@section('content')

    @isset($redireccion)
        <li id="accion" name="accion" @click="menu={{ $redireccion }}" class="d-none"></li>
        <input type="hidden" id="redireccion" name="redireccion" value="{{ $redireccion }}">
    @endisset

    @if(Auth::user()->tipo_usuario == 1)
        @include('menu.admin')
    @elseif(Auth::user()->tipo_usuario == 2)
        @include('menu.admin')
    @elseif(Auth::user()->tipo_usuario == 3)
        @include('menu.usuario')
    @endif
@endsection


@section('script')
    <script>
        $(document).ready(function() {
            var redireccion = $('#redireccion').val()

            if(redireccion){
                $('#accion').click()
            }
        });
    </script>
@endsection
