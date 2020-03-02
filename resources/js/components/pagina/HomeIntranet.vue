<template>
    <div class="page-wrapper">
        <b-container fluid class="mb-5">
            <b-row class="page-titles">
                <b-col xs="12" sm="12" md="5" class="align-self-center"><h4 class="text-themecolor">Home usuario</h4></b-col>
                <b-col xs="12" sm="12" md="7">
                    <div class="d-flex justify-content-end align-items-right">
                        <sociales></sociales>
                        <b-button @click="actualizarPagina()" class="btn btn-success d-lg-block m-l-15" v-b-tooltip.hover title="Actualiza información general de la página"><i class="fa fa-plus-circle"></i> Actualizar página</b-button>
                        <b-spinner class="ml-2" variant="success" label="Spinning" v-show="spinner.estado == 1"></b-spinner>
                    </div>
                </b-col>
            </b-row>

            <b-row>
                <b-col>
                    <b-card>
                        <b-form-group label="Contenido">
                            <b-form-textarea v-model="pagina.contenido" placeholder="Ingresa el mensaje ..." rows="3" max-rows="6"></b-form-textarea>
                        </b-form-group>
                    </b-card>
                </b-col>
                <b-col>
                    <b-card title="Imagen">
                        <b-row>
                            <center>
                                <b-form-group label-for="imagen">
                                    <b-form-file block id="imagen" name="imagen" v-model="pagina.imagen" @input="ver_imagen" accept="image/png" placeholder="Escoge un archivo o suelta aquí" drop-placeholder="Suelta aquí"></b-form-file>
                                </b-form-group>
                                <b-img v-show="pagina.url_imagen != ''" :src="pagina.url_imagen" height="150"></b-img>
                            </center>
                        </b-row>
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
                pagina: {
                    contenido: '',
                    imagen: null,
                    url_imagen: null
                },
                spinner: {
                    estado: 0
                }
            }
        },
        methods:{
            ver_imagen(file){
                this.pagina.url_imagen = URL.createObjectURL(file);
            },
            listarPagina (){
                let me=this;
                axios.get('/pagina/home/usuario').then(function (response) {
                    me.pagina.contenido = response.data.pagina.contenido
                    me.pagina.url_imagen = response.data.pagina.video_url != null ? 'storage/' + response.data.general.logo_url : '';
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            actualizarPagina(){
                let me = this;

                let formData = new FormData();

                this.spinner.estado = 1;

                let imagen = document.querySelector('#imagen');

                if(imagen){
                    formData.append('imagen', imagen.files[0]);
                }

                formData.append('contenido', me.pagina.contenido);

                axios.post('/pagina/home/usuario/actualizar',formData).then(function (response) {
                    Vue.$toast.open({
                        message: 'Página actualizada exitosamente',
                        type: 'success',
                        duration: 5000
                    });

                    me.spinner.estado = 0
                    me.listarPagina()
                }).catch(function (error) {
                    console.error(error);
                });
            }
        },
        mounted(){
            this.listarPagina();
        }
    }
</script>
