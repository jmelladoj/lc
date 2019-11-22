@extends('layouts.app')

@section('content')
    <section class="sec-padding-login">
        <div class="container">
            <div class="row justify-content-around">               
                @if($errors->any())
                    <div class="col-md-12">
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif      
            </div>  

            <div class="row">
                <div class="offset-md-2 col-md-8" v-show="formulario == 0">
                    <div class="my-account-box mb-4" id="ingreso" name="ingreso">
                        <form class="form-full-height" method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <h2>Inicia tu sesión</h2>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="button" class="mt-0 btn btn--secondary space--1 btn-sm" @click="formulario = 1">... Regístrate</button>
                                </div>
                            </div>                       
                            
                            <p class="large text-justify">Bienvenido a tu comunidad LebenCo.</p>
                            <p class="form-field-wrapper">
                                <input class="input--lg form-full run" name="run" id="run" autocomplete="run" type="text" placeholder="RUN personal o RUT si eres una Pyme" value="{{ old('run') }}" required>
                            </p>
                            <p class="form-field-wrapper">
                                <input class="input--lg form-full" name="password" id="password" autocomplete="current-password" type="password" placeholder="Ingresa tu clave" required>
                            </p>
                            <p class="form-field-wrapper">
                                <label class="">
                                    <input class="" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} type="checkbox">
                                    <span>Recuérdame</span>
                                </label>
                            </p>
                            <p class="form-field-wrapper form-row">
                                <button type="submit" class="btn btn--lg btn--secondary" name="login" value="Log in">Ingresar</button>
                            </p>
                            <p class="form-field-wrapper lost_password">
                                <a href="#" class="sale-color">Olvide mi clave</a>
                            </p>
                        </form>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="my-account-box" id="registro" name="registro" v-show="formulario == 1">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <h2>Regístrate</h2>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="button" class="mt-0 btn btn--secondary space--1 btn-sm" @click="formulario = 0">... Inicia tu sesión</button>
                                </div>
                            </div>
                            <p class="large text-justify">Disponemos de herramientas para Pymes, Estudiantes del área, Prevencionistas y Personas encargadas de la prevención.</p> 
                            <p class="form-field-wrapper">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 d-flex align-items-center justify-content-center">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="estudiante" name="tipo_persona" class="custom-control-input" value="3">
                                            <label class="custom-control-label" for="estudiante"> Estudiante</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 d-flex align-items-center justify-content-center">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="persona" name="tipo_persona" class="custom-control-input" value="1">
                                            <label class="custom-control-label" for="persona"> Prevencionista</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 d-flex align-items-center justify-content-center">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="empresa" name="tipo_persona" class="custom-control-input" value="2">
                                            <label class="custom-control-label" for="empresa"> Pyme</label>
                                        </div>
                                    </div>
                                </div>
                            </p>
                            <p class="form-field-wrapper">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4">
                                        <input class="input--lg form-full" name="nombre" id="nombre" type="text" placeholder="Nombre completo o Razón social" value="{{ old('nombre') }}" required>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <input class="input--lg form-full run" name="run" id="run" type="text" placeholder="RUN personal o RUT si eres una Pyme" value="{{ old('run') }}" required>
                                        <div id="error_rut" name="error_rut" class="alert alert-danger" role="alert">
                                            <span>El rut o run ingresado no es válido</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <input class="input--lg form-full" name="email" id="email" type="email" placeholder="Correo electrónico" value="{{ old('email') }}" required>
                                    </div>
                                </div>
                            </p>
                            <p class="form-field-wrapper">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <input class="input--lg form-full" name="clave_uno" id="clave_uno" type="password" placeholder="Crea tu clave (6 caracteres)" required>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <input class="input--lg form-full" name="clave_dos" id="clave_dos" type="password" placeholder="Repite esa clave" required>
                                    </div>
                                </div>
                            </p>
                            <p class="form-field-wrapper text-justify">
                                Sus datos personales se utilizarán con el fin de respaldar su experiencia en nuestro sitio web, administrar el acceso a su cuenta y para otros fines descritos en <a class="sale-color" href="{{ url('/politicas') }}" target="_blank">nuestras Políticas </a>, al registrarse usted acepta nuestros términos de uso y condiciones de privacidad, que han sido establecidas por Prevención LebenCo. SpA.
                                
                            </p>
                            <p class="form-field-wrapper">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="">
                                            <input class="" name="mailing" id="mailing" {{ old('mailing') ? 'checked' : '' }} type="checkbox">
                                            <span>Quiero recibir notificaciones importantes de la comunidad LebenCo.</span>
                                        </label>
                                    </div>   
                                    <div class="col-md-6 text-right">
                                        <button type="submit" class="btn btn--lg btn--secondary" name="register" value="Register">Registrarme</button>
                                    </div>   
                                </div>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
