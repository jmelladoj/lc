<template>
    <ValidationObserver ref="observer_invitar_amigo" v-slot="{ valid }">
        <b-modal ref="modal_invitar_amigo" title="Invita a un amigo" no-close-on-backdrop scrollable>
            <b-form>
                <b-form-group label="Ingresa el correo de tu amigo">
                    <ValidationProvider name="correo" rules="required|email" v-slot="{ errors }">
                        <b-form-input type="email" v-model="invitacion.email"></b-form-input>
                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                    </ValidationProvider>
                </b-form-group>
            </b-form>

            <template slot="modal-footer">
                <b-button :disabled="!valid" size="md" variant="success" @click="invitarAmigo()"> Enviar invitación </b-button>
                <b-button size="md" variant="danger" @click="cerrarModal()"> Cerrar </b-button>
            </template>
        </b-modal>
    </ValidationObserver>
</template>

<script>
    export default {
        data() {
            return {
                invitacion: {
                    email: ''
                }
            }
        },    
        methods:{
            invitarAmigo(){
                let me = this;
                axios.post('/invitar',{
                    'email': me.invitacion.email
                }).then(function (response) {
                    me.cerrarModal();

                    Vue.$toast.open({
                        message: response.data.mensaje,
                        type: response.data.clase,
                        duration: 5000
                    });

                    this.$destroy();
                }).catch(function (error) {
                    console.error(error);
                });
            },
            cerrarModal(){
                this.invitacion.email = "";
                this.$refs['modal_invitar_amigo'].hide();
            }
        },
        mounted() {
            this.$refs['modal_invitar_amigo'].show();
        }
    }
</script>