<template>
    <div class="page-wrapper">
        <b-container fluid>
            <b-row class="page-titles">
                <b-col xs="12" sm="12" md="5" class="align-self-center"><h4 class="text-themecolor">Login</h4></b-col>
                <b-col xs="12" sm="12" md="7">
                    <div class="d-flex justify-content-end align-items-right">
                        <sociales></sociales>
                        <b-button @click="actualizarPagina()" class="btn btn-success d-lg-block m-l-15" v-b-tooltip.hover title="Actualiza información de la página login"><i class="fa fa-plus-circle"></i> Actualizar página</b-button>
                    </div>
                </b-col>
            </b-row>

            <b-row>
                <b-col>
                    <b-card>
                        <b-form-group label="Mensaje uno">
                            <b-form-textarea v-model="pagina.mensaje_uno" placeholder="Ingresa el mensaje ..." rows="3" max-rows="6"></b-form-textarea>
                        </b-form-group>
                        <b-form-group label="Mensaje dos">
                            <b-form-textarea v-model="pagina.mensaje_dos" placeholder="Ingresa el mensaje ..." rows="3" max-rows="6"></b-form-textarea>
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
                    mensaje_uno: '',
                    mensaje_dos: ''
                }
            }
        },
        methods:{
             listarLogin (){
                let me=this;
                axios.get('/pagina/registro').then(function (response) {
                    me.pagina.mensaje_uno = response.data.pagina.mensaje_uno;
                    me.pagina.mensaje_dos = response.data.pagina.mensaje_dos;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            actualizarPagina(){
                let me = this;

                axios.post('/pagina/login/actualizar',{
                    'mensaje_uno': me.pagina.mensaje_uno,
                    'mensaje_dos': me.pagina.mensaje_dos
                }).then(function (response) {

                    Vue.$toast.open({
                        message: 'Página actualizada exitosamente',
                        type: 'success',
                        duration: 5000
                    });

                }).catch(function (error) {
                    console.error(error);
                });
            }
        },
        mounted() {
            this.listarLogin();
        }
    }
</script>
