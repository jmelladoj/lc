@extends('layouts.app')

@section('content')

    <contacto @auth :user="{{ json_encode(Auth::user()) }}" @endauth></contacto>

@endsection
