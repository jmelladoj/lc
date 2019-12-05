<template>
    <ValidationObserver ref="observer_solicitud_documento" v-slot="{ valid }">
        <b-modal ref="modal_solicitud_documento" title="Solicitar documento" no-close-on-backdrop scrollable>
            <b-form>
                <b-form-group label="Describe tu requerimiento ...">
                    <ValidationProvider name="requerimiento" rules="required|min:10" v-slot="{ errors }">
                        <b-form-textarea v-model="solicitud.descripcion" rows="3" max-rows="6"></b-form-textarea>
                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                    </ValidationProvider>
                </b-form-group>

                <b-form-group label="¿Cuánto estás dispuesto a pagar?">
                    <ValidationProvider name="pago" rules="required|numeric|min_value:1" v-slot="{ errors }">
                        <b-form-input type="number" v-model="solicitud.pago"></b-form-input>
                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                    </ValidationProvider>
                </b-form-group>

                <b-form-group label="Plazo de entrega (días) ...">
                    <ValidationProvider name="plazo" rules="required|numeric|min_value:1" v-slot="{ errors }">
                        <b-form-input type="number" v-model="solicitud.plazo"></b-form-input>
                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                    </ValidationProvider>
                </b-form-group>

                <b-form-group label="Observación">
                    <b-alert variant="warning" show class="text-justify">
                        Recuerda que debes ser conciente con la valoración del trabajo de los profesionales, de lo contrario te arriesgas a que tu propuesta no sea atractiva para la comunidad. <br><br>
                        Para asegurar el cumplimiento de la entrega, considera que para cualquier documento escencial el plazo es 24hrs, pero si el documento es complejo este plazo base puede incrementarse y al igual que el monto.<br><br>
                        Considera que se descontará inmediatamente de tu saldo, el monto a pago que propones.
                    </b-alert>
                </b-form-group>

            </b-form>

            <template slot="modal-footer">
                <b-button :disabled="!valid" size="md" variant="success" @click="solicitarDocumento()"> Enviar pedido </b-button>
                <b-button size="md" variant="danger" @click="cerrarModal()"> Cerrar </b-button>
            </template>
        </b-modal>
    </ValidationObserver>
</template>

<script>
    export default {
        data() {
            return {
                solicitud: {
                    descripcion: '',
                    pago: 0,
                    plazo: 0
                }
            }
        },    
        methods:{
            solicitarDocumento(){
                let me = this;
                axios.post('/solicitar/documento',{
                    'descripcion': me.solicitud.descripcion,
                    'pago': me.solicitud.pago,
                    'plazo': me.solicitud.plazo
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
                this.solicitud.descripcion = "";
                this.solicitud.pago = 0;
                this.solicitud.plazo = 0;
                this.$refs['modal_solicitud_documento'].hide();
            }
        },
        mounted() {
            this.$refs['modal_solicitud_documento'].show();
        }
    }
</script>