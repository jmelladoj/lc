<template>
    <div class="page-wrapper">
        <b-container fluid class="mb-5">
            <b-row class="page-titles">
                <b-col cols="5" class="align-self-center"><h4 class="text-themecolor">General</h4></b-col>
                <b-col cols="7">
                    <div class="d-flex justify-content-end align-items-right">
                        <sociales></sociales>
                        <b-button @click="actualizarPagina()" class="btn btn-success d-lg-block m-l-15" v-b-tooltip.hover title="Actualiza información general de la página"><i class="fa fa-plus-circle"></i> Actualizar página</b-button>
                        <b-spinner class="ml-2" variant="success" label="Spinning" v-show="spinner.estado == 1"></b-spinner>
                    </div>                    
                </b-col>
            </b-row>

            <b-row>
                <b-col>
                    <b-card title="Logos">
                        <b-row>
                            <b-col class="text-center">
                                <b-form-group label="Logo (150px alto X 34px ancho | PNG):" label-for="logo">
                                    <b-form-file id="logo" name="logo" v-model="logo_file" :state="Boolean(logo_file)" @input="ver_imagen" accept="image/png" placeholder="Escoge un archivo o suelta aquí" drop-placeholder="Suelta aquí"></b-form-file>
                                </b-form-group>
                                <b-img v-show="logo != ''" :src="logo" height="150"></b-img>
                            </b-col>
                            <b-col class="text-center">
                                <b-form-group label="Favicon (155px alto X 95px ancho | PNG):" label-for="favicon">
                                    <b-form-file id="favicon" name="favicon" accept="image/png" placeholder="Sin archivo"></b-form-file>
                                </b-form-group>
                                <b-img v-show="favicon != ''" :src="favicon" height="150"></b-img>
                            </b-col>
                            <b-col class="text-center">
                                <b-form-group label="Footer (150px alto X 34px ancho | PNG)" label-for="logo_footer">
                                    <b-form-file id="logo_footer" name="logo_footer" accept="image/png" placeholder="Sin archivo"></b-form-file>
                                </b-form-group>
                                <b-img v-show="footer != ''" :src="footer" height="150"></b-img>
                            </b-col>
                        </b-row>                    
                    </b-card>
                    <b-card title="Documentación">
                        <b-form-group label="Terminos y condiciones" label-for="terminos" label-cols-sm="4">
                            <b-form-file id="terminos" name="terminos" accept=".pdf" placeholder="Sin archivo"></b-form-file>
                        </b-form-group>
                        <b-form-group label="Políticas de privacidad" label-for="privacidad" label-cols-sm="4">
                            <b-form-file id="privacidad" name="privacidad" accept=".pdf" placeholder="Sin archivo"></b-form-file>
                        </b-form-group>
                        <b-form-group label="Políticas de satisfacción" label-for="satisfaccion" label-cols-sm="4">
                            <b-form-file id="satisfaccion" name="satisfaccion" accept=".pdf" placeholder="Sin archivo"></b-form-file>
                        </b-form-group>
                        <b-form-group label="Políticas de derecho de autor" label-for="derechos" label-cols-sm="4">
                            <b-form-file id="derechos" name="derechos" accept=".pdf" placeholder="Sin archivo"></b-form-file>
                        </b-form-group>
                    </b-card>
                </b-col>
            </b-row>
            
        </b-container>

    </div>
</template>

<script>
    export default {   
        data(){
            return {
                logo_file: null,
                logo: '',
                favicon: '',
                footer: '',
                spinner: {
                    estado: 0
                }
            }
        },
        methods:{
            ver_imagen(file){
                this.logo = URL.createObjectURL(file);
            },
            listarGeneral (){
                let me=this;
                axios.get('/general').then(function (response) {
                    me.logo = response.data.general.logo_url != null ? 'storage/' + response.data.general.logo_url : '';
                    me.favicon = response.data.general.favicon_url != null ? 'storage/' + response.data.general.favicon_url : '';
                    me.footer = response.data.general.logo_fot_url != null ? 'storage/' + response.data.general.logo_fot_url : '';
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            actualizarPagina(){
                let me = this;

                let formData = new FormData();

                this.spinner.estado = 1;

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
                    Vue.$toast.open({
                        message: 'Página actualizada exitosamente',
                        type: 'success',
                        duration: 5000
                    });

                    me.spinner.estado = 0
                    me.listarGeneral()
                }).catch(function (error) {
                    console.error(error);
                });
            }
        },
        mounted(){
            this.listarGeneral();
        }
    }
</script>
