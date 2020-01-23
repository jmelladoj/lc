<template>
    <div class="page-wrapper">
        <b-container fluid>
            <b-row class="page-titles">
                <b-col cols="5" class="align-self-center"><h4 class="text-themecolor">Nosotros</h4></b-col>
                <b-col cols="7">
                    <div class="d-flex justify-content-end align-items-right">
                        <sociales></sociales>
                        <b-button @click="actualizarPagina()" class="btn btn-success d-lg-block m-l-15" v-b-tooltip.hover title="Actualiza información de la página nosotros"><i class="fa fa-plus-circle"></i> Actualizar página</b-button>
                        <b-spinner class="float-left" variant="success" label="Spinning" v-show="spinner.estado == 1"></b-spinner>
                    </div>
                </b-col>
            </b-row>

            <b-row>
                <b-col>
                    <b-card>
                        <b-row>
                            <b-col cols="2">
                                <b-form-group>
                                    <b-form-radio v-model="pagina.tipo" name="tipo" value="1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Link</b-form-radio>
                                    <b-form-radio v-model="pagina.tipo" name="tipo" value="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Archivo</b-form-radio>
                                </b-form-group>
                            </b-col>
                            <b-col v-if="pagina.tipo != 0">
                                <b-form-group label="Vídeo:" label-for="video" label-cols-sm="2">
                                    <b-form-input v-model="pagina.link" v-if="pagina.tipo == 1"></b-form-input>
                                    <b-form-file id="video" name="video" accept="video/*" placeholder="Sin archivo" v-else></b-form-file>
                                </b-form-group>
                            </b-col>
                            <b-col v-else>
                                <h3 for="" v-text="pagina.nombre_video"></h3>
                            </b-col>
                            <b-col>
                               <b-button @click="eliminar_video" class="btn btn-danger d-lg-block m-l-15" v-b-tooltip.hover title="Eliminar vídeo"><i class="fa fa-plus-circle"></i> Eliminar vídeo</b-button>
                            </b-col>
                        </b-row>

                        <b-form-group>
                            <tinymce apiKey="5pb70j35mtgqauwus85v88pphv2ig89gwfx0y7s7nhfdd3e8" id="d1" v-model="pagina.contenido" :init="{ plugins: 'spellchecker', menubar: 'tools', toolbar: 'spellchecker', spellchecker_languages: 'English=en,Danish=da,Dutch=nl,Finnish=fi,French=fr_FR,' + 'German=de,Italian=it,Polish=pl,Portuguese=pt_BR,Spanish=es,Swedish=sv' }" :other_options="options"></tinymce>
                        </b-form-group>
                    </b-card>
                </b-col>
            </b-row>

        </b-container>

    </div>
</template>

<script>
    import SpellChecker from 'tinymce/plugins/spellchecker';

    export default {
        data() {
            return {
                pagina: {
                    nombre_video: '',
                    contenido: '',
                    tipo: 0,
                    link: ''
                },
                options: {
                    language_url: 'intranet/js/es_ES.js',
                    height: '500px'
                },
                spinner: {
                    estado: 0
                }
            }
        },
        methods:{
            listarNosotros (){
                let me=this;
                axios.get('/pagina/nosotros').then(function (response) {
                    me.pagina.contenido = response.data.contenido.contenido;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listarVideo (){
                let me=this;
                axios.get('/pagina/nosotros').then(function (response) {
                    me.pagina.nombre_video = response.data.contenido.video_titulo;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            actualizarPagina(){
                let me = this;

                this.spinner.estado = 1

                let formData = new FormData()

                formData.append('contenido', this.pagina.contenido);

                if(this.pagina.tipo == 1){
                    formData.append('link', this.pagina.link);
                } else if(this.pagina.tipo == 2){
                    let video = document.querySelector('#video');
                    formData.append('video', video.files[0]);
                }

                axios.post('/pagina/nosotros/actualizar', formData).then(function (response) {
                    Vue.$toast.open({
                        message: 'Página actualizada exitosamente',
                        type: 'success',
                        duration: 5000
                    });

                    me.pagina.tipo = 0;
                    me.pagina.link = '';
                    me.listarNosotros();
                    me.listarVideo();
                    me.spinner.estado = 0
                }).catch(function (error) {
                    console.error(error);
                });
            },
            eliminar_video(){
                let me = this;

                axios.post('/pagina/video/eliminar').then(function (response) {
                    Vue.$toast.open({
                        message: 'Vídeo eliminado exitosamente',
                        type: 'success',
                        duration: 5000
                    });

                    me.listarVideo();
                }).catch(function (error) {
                    console.error(error);
                });
            }
        },
        mounted() {
            this.listarNosotros();
            this.listarVideo();
        }
    }
</script>
