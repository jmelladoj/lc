<template>
    <div class="page-wrapper">
        <b-container fluid>
            <b-row class="page-titles">
                <b-col cols="5" class="align-self-center"><h4 class="text-themecolor">General</h4></b-col>
                <b-col cols="7">
                    <div class="d-flex justify-content-end align-items-right">
                        <b-button @click="actualizarPagina()" class="btn btn-info d-lg-block m-l-15" v-b-tooltip.hover title="Actualiza información general de la página"><i class="fa fa-plus-circle"></i> Actualizar página</b-button>
                    </div>                    
                </b-col>
            </b-row>

            <b-row>
                <b-col>
                    <b-card title="Logos">
                        <b-form-group label="Logo (155px alto X 95px ancho | PNG):" label-for="logo" label-cols-sm="4">
                            <b-form-file id="logo" name="logo" accept="image/png"></b-form-file>
                        </b-form-group>
                        <b-form-group label="Favicon (155px alto X 95px ancho | PNG):" label-for="favicon" label-cols-sm="4">
                            <b-form-file id="favicon" name="favicon" accept="image/png"></b-form-file>
                        </b-form-group>
                        <b-form-group label="Logo Footer (155px alto X 95px ancho | PNG):" label-for="logo_footer" label-cols-sm="4">
                            <b-form-file id="logo_footer" name="logo_footer" accept="image/png"></b-form-file>
                        </b-form-group>
                    </b-card>
                    <b-card title="Documentación">
                        <b-form-group label="Terminos y condiciones" label-for="terminos" label-cols-sm="4">
                            <b-form-file id="terminos" name="terminos" accept=".pdf"></b-form-file>
                        </b-form-group>
                        <b-form-group label="Políticas de privacidad" label-for="privacidad" label-cols-sm="4">
                            <b-form-file id="privacidad" name="privacidad" accept=".pdf"></b-form-file>
                        </b-form-group>
                        <b-form-group label="Políticas de satisfacción" label-for="satisfaccion" label-cols-sm="4">
                            <b-form-file id="satisfaccion" name="satisfaccion" accept=".pdf"></b-form-file>
                        </b-form-group>
                        <b-form-group label="Políticas de derecho de autor" label-for="derechos" label-cols-sm="4">
                            <b-form-file id="derechos" name="derechos" accept=".pdf"></b-form-file>
                        </b-form-group>


                    </b-card>
                </b-col>
            </b-row>
            
        </b-container>

    </div>
</template>

<script>
    export default {   
        methods:{
            mensaje(clase, mensaje) {

            },
            actualizarPagina(){
                let me = this;

                let formData = new FormData();

                let logo = document.querySelector('#logo');
                formData.append('logo', logo.files[0]);

                let favicon = document.querySelector('#favicon');
                formData.append('favicon', favicon.files[0]);

                let logo_footer = document.querySelector('#logo_footer');
                formData.append('logo_footer', logo_footer.files[0]);

                let terminos = document.querySelector('#terminos');
                formData.append('terminos', terminos.files[0]);

                let privacidad = document.querySelector('#privacidad');
                formData.append('privacidad', privacidad.files[0]);

                let satisfaccion = document.querySelector('#satisfaccion');
                formData.append('satisfaccion', satisfaccion.files[0]);

                let derechos = document.querySelector('#derechos');
                formData.append('derechos', derechos.files[0]);

                axios.post('/general/actualizar',formData).then(function (response) {
                    Swal.fire({
                        type: 'success',
                        title: 'Página actualizada exitosamente',
                        showConfirmButton: true,
                        timer: 2000
                    });
                }).catch(function (error) {
                    console.error(error);
                });
            }
        }
    }
</script>
