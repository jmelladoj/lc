<template>
    <div>
        <h6 class="footer-widget-title"><a href="#" @click="abrir_modal_trabaja" class="text-dark" style="opacity: 1;">Trabaja en LebenCo.</a></h6>

        <b-modal ref="modal_trabaja">
            <h4 class="my-4 text-justify" v-text="mensaje_trabaja"></h4>

            <template slot="modal-footer">
                <b-button size="md" variant="danger" @click="cerrar_modal_trabaja()"> Cerrar </b-button>
                <b-button size="md" variant="success" @click="redireccion()"> ¡Regístrate! </b-button>
            </template>
        </b-modal>
    </div>
</template>


<script>
    export default {
        data(){
            return {
                mensaje_trabaja: ''
            }
        },
        methods:{
            listarGeneral (){
                let me=this;
                axios.get('/general').then(function (response) {
                    me.mensaje_trabaja = response.data.general.mensaje_trabaja
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            abrir_modal_trabaja(){
                this.$refs['modal_trabaja'].show();
            },
            cerrar_modal_trabaja(){
                this.$refs['modal_trabaja'].hide();
            },
            redireccion(){
                window.location.href = "/login"
            }
        },
        mounted(){
            this.listarGeneral();
        }
    }
</script>
