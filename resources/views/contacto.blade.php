@extends('layouts.app')

@section('content')

    <section class="sec-padding-login">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="page-title">Contáctate con nosotros</h2>
                    <form class="Contact-form">
                        <div class="row">
                            <div class="form-field-wrapper col-md-6">
                                <input id="author" class="input--lg form-full" name="author" placeholder="Nombre completo o Razón social si eres una Pyme" value="" size="30" aria-required="true" required="" type="text">
                            </div>
                            <div class="form-field-wrapper col-md-6">
                                <input id="author-email" class="input--lg form-full" name="author" placeholder="Ingresa tu correo electrónico" value="" size="30" aria-required="true" required="" type="email">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-field-wrapper col-md-6">
                                <input id="subject" class="input--lg form-full" name="author" placeholder="Ingresa el asunto del mensaje" value="" size="30" aria-required="true" required="" type="text">
                            </div>
                            <div class="form-field-wrapper col-md-6">
                                <input id="author-email" class="input--lg form-full" name="author" placeholder="Ingresa tu número telefónico para ser contactado Ej. 56 9 8745 432" value="" size="30" aria-required="true" required="" type="text">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-field-wrapper col-md-6">
                                <textarea id="comment" class="input--lg form-full" name="comment" placeholder="Tu consulta es muy importante para nosotros" cols="45" rows="8" aria-required="true" required=""></textarea>
                            </div>
                            <div class="form-field-wrapper col-md-6">
                                <p class="large text-justify">La comunidad LebenCo. dispone de herramientas para Estudiantes del área, Prevencionistas o Personas encargadas de la prevención y nuestras Pymes.</p> 
                                <p class="form-field-wrapper">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="estudiante" name="tipo_persona" class="custom-control-input" value="3">
                                                <label class="custom-control-label" for="estudiante"> Estudiante</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="persona" name="tipo_persona" class="custom-control-input" value="1">
                                                <label class="custom-control-label" for="persona"> Prevencionista</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="empresa" name="tipo_persona" class="custom-control-input" value="2">
                                                <label class="custom-control-label" for="empresa"> Pyme</label>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="form-field-wrapper col-md-12">
                                            <input name="submit" id="submit" class="submit btn btn--lg btn--primary" value="Enviar mensaje" type="submit">
                                        </div>
                                    </div>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="contact-information">
                        <div class="form-field-wrapper">
                            <label style="font-size: 17px;">Si necesitas asistencia técnica sobre la plataforma, puedes encontrarnos en</label>
                            <p>
                                <i class="ti-email left"></i>soporte@prevencionlebenco.cl
                            </p>
                        </div>
                    </div>
                    <div class="contact-information">
                        <div class="form-field-wrapper">
                            <label style="font-size: 17px;">Para todo lo demás, puedes encontrarnos en</label>
                            <p>
                                <i class="ti-email left"></i>contacto@prevencionlebenco.cl
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End Contact Form & Info-->

    <sliders-ubicacion :ubicacion="4"></sliders-ubicacion>

@endsection
