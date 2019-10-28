<template>
    <div class="page-wrapper">
        <b-container fluid>
            <b-row class="page-titles">
                <b-col cols="5" class="align-self-center"><h4 class="text-themecolor">Nosotros</h4></b-col>
                <b-col cols="7">
                    <div class="d-flex justify-content-end align-items-right">
                        <ol class="breadcrumb">
                            <li><a href="https://www.youtube.com/channel/UC78DsrgVX7KslItHoTuw8uQ?view_as=subscriber" target="_blank" aria-expanded="false" class="breadcrumb-item active h3 pl-1 pr-1"><i class="fa fa-youtube"></i></a></li>
                            <li><a href="https://www.facebook.com/prevencion.lebenco.3" target="_blank" aria-expanded="false" class="breadcrumb-item active h3 pl-1 pr-1"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="https://www.instagram.com/prevencionlebenco.cl/?hl=es-la" target="_blank" aria-expanded="false" class="breadcrumb-item active h3 pl-1 pr-1"><i class="fa fa-instagram"></i></a></li>
                            <li><a href="https://www.linkedin.com/in/prevenci%C3%B3n-lebenco-62b632184/" target="_blank" aria-expanded="false" class="breadcrumb-item active h3 pl-1 pr-1"><i class="fa fa-linkedin"></i></a></li>
                        </ol>
                        <b-button @click="actualizarPagina()" class="btn btn-info d-lg-block m-l-15" v-b-tooltip.hover title="Actualiza información de la página nosotros"><i class="fa fa-plus-circle"></i> Actualizar página</b-button>
                    </div>                    
                </b-col>
            </b-row>

            <b-row>
                <b-col>
                    <b-card>
                        <b-form-group>
                            <tinymce id="d1" v-model="pagina.contenido" :other_options="options"></tinymce>
                        </b-form-group>
                        <b-form-group label="Vídeo:" label-for="video" label-cols-sm="2">
                            <b-form-file id="video" name="video" accept="video/*"></b-form-file>
                        </b-form-group>
                    </b-card>
                </b-col>
            </b-row>
            
        </b-container>

    </div>
</template>

<script>
    export default {  
        data() {
            return {
                pagina: {
                    contenido: ''
                },
                options: {
                    language_url: 'js/es.js' //This url points to location of persian language file.
                }
            }
        },  
        methods:{
            mensaje(clase, mensaje) {
                Swal.fire({
                    type: clase,
                    title: mensaje,
                    showConfirmButton: true,
                    timer: 2000
                });
            },
            listarNosotros (){
                let me=this;
                axios.get('/pagina/nosotros').then(function (response) {
                    me.pagina.contenido = response.data.contenido;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            actualizarPagina(){
                let me = this;

                let formData = new FormData();

                let video = document.querySelector('#video');
                formData.append('video', video.files[0]);

                formData.append('contenido', this.pagina.contenido);

                axios.post('/pagina/nosotros/actualizar',formData).then(function (response) {
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
        },
        mounted() {
            this.listarNosotros();
        }
    }
</script>
