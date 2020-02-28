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
                    <b-card title="Logos - Imágenes (100px como máximo):">
                        <b-row>
                            <b-col class="text-center">
                                <b-form-group label-for="logo">
                                    <b-form-file id="logo" name="logo" @input="ver_imagen_logo" accept="image/png" placeholder="Arrastra o pincha aquí" drop-placeholder="Suelta aquí"></b-form-file>
                                </b-form-group>
                                <b-img v-show="logo != ''" :src="logo" fluid height="150" class="imagen"></b-img>
                            </b-col>
                            <b-col class="text-center">
                                <b-form-group label-for="favicon">
                                    <b-form-file id="favicon" name="favicon" @input="ver_imagen_favicon" accept="image/png" placeholder="Arrastra o pincha aquí" drop-placeholder="Suelta aquí"></b-form-file>
                                </b-form-group>
                                <b-img v-show="favicon != ''" :src="favicon" fluid height="150" class="imagen"></b-img>
                            </b-col>
                            <b-col class="text-center">
                                <b-form-group label-for="logo_footer">
                                    <b-form-file id="logo_footer" name="logo_footer" @input="ver_imagen_logo_footer" accept="image/png" placeholder="Arrastra o pincha aquí" drop-placeholder="Suelta aquí"></b-form-file>
                                </b-form-group>
                                <b-img v-show="footer != ''" :src="footer" fluid height="150" class="imagen"></b-img>
                            </b-col>
                            <b-col class="text-center">
                                <b-form-group label-for="logo_escritorio">
                                    <b-form-file id="logo_escritorio" name="logo_escritorio" @input="ver_imagen_logo_escritorio" accept="image/png" placeholder="Arrastra o pincha aquí" drop-placeholder="Suelta aquí"></b-form-file>
                                </b-form-group>
                                <b-img v-show="escritorio != ''" :src="escritorio" fluid height="150" class="imagen"></b-img>
                            </b-col>
                        </b-row>
                    </b-card>
                    <b-card title="Mensaje de modal trabaja con nosotros">
                        <b-form-group>
                            <b-form-textarea v-model="mensaje_trabaja" placeholder="Ingresa el mensaje ..." rows="3" max-rows="6"></b-form-textarea>
                        </b-form-group>
                    </b-card>
                    <b-card title="Políticas">
                        <b-form-group>
                            <tinymce apiKey="5pb70j35mtgqauwus85v88pphv2ig89gwfx0y7s7nhfdd3e8" id="d1" v-model="politicas" :init="{ plugins: 'spellchecker', menubar: 'tools', toolbar: 'spellchecker', spellchecker_languages: 'English=en,Danish=da,Dutch=nl,Finnish=fi,French=fr_FR,' + 'German=de,Italian=it,Polish=pl,Portuguese=pt_BR,Spanish=es,Swedish=sv' }" :other_options="options"></tinymce>
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
                escritorio: '',
                spinner: {
                    estado: 0
                },
                options: {
                    language_url: 'intranet/js/es_ES.js',
                    height: '500px'
                },
                politicas: '',
                mensaje_trabaja: ''
            }
        },
        methods:{
            ver_imagen_logo(file){
                this.logo = URL.createObjectURL(file);
            },
            ver_imagen_favicon(file){
                this.favicon = URL.createObjectURL(file);
            },
            ver_imagen_logo_footer(file){
                this.footer = URL.createObjectURL(file);
            },
            ver_imagen_logo_escritorio(file){
                this.escritorio = URL.createObjectURL(file);
            },
            listarGeneral (){
                let me=this;
                axios.get('/general').then(function (response) {
                    me.logo = response.data.general.logo_url != null ? 'storage/' + response.data.general.logo_url : '';
                    me.favicon = response.data.general.favicon_url != null ? 'storage/' + response.data.general.favicon_url : '';
                    me.footer = response.data.general.logo_fot_url != null ? 'storage/' + response.data.general.logo_fot_url : '';
                    me.escritorio = response.data.general.logo_escritorio_url != null ? 'storage/' + response.data.general.logo_escritorio_url : '';
                    me.politicas = response.data.general.terminos_url != null ? response.data.general.terminos_url  : ''
                    me.mensaje_trabaja = response.data.general.mensaje_trabaja
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

                let logo_escritorio = document.querySelector('#logo_escritorio');
                formData.append('logo_escritorio', logo_escritorio.files[0]);

                formData.append('terminos', me.politicas);
                formData.append('mensaje_trabaja', me.mensaje_trabaja);

                axios.post('/general/actualizar',formData).then(function (response) {
                    Vue.$toast.open({
                        message: 'Página actualizada exitosamente',
                        type: 'success',
                        duration: 5000
                    });

                    me.spinner.estado = 0
                    //me.listarGeneral()
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
