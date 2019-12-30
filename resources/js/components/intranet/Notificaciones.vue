<template>
    <li class="nav-item dropdown" v-show="notificaciones.length > 0">
        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> {{ total }} <i class="fa fa-bell"></i>
            <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
        </a>
        <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown">
            <ul>
                <li>
                    <div class="drop-title">Notificaciones</div>
                </li>
                <li>
                    <div class="message-center ps ps--theme_default" data-ps-id="1f364355-630f-3dc6-d666-9e64a51ae8da">

                        <a href="javascript:void(0)" v-for="notificacion in notificaciones" :key="notificacion.id" @click="cambiarMenu()">
                            <div v-if="notificacion.data.usuario != null" class="btn btn-warning btn-circle"><i v-bind:class="notificacion.data.clase"></i></div>
                            <div v-if="notificacion.data.usuario != null" class="mail-contnet">
                                <h5 v-text="notificacion.data.usuario.nombre"></h5> 
                                <span class="mail-desc" v-text="notificacion.data.mensaje"></span> 
                                <span class="time" v-text="notificacion.data.created_at"></span> 
                            </div>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </li>
</template>

<script>
    export default {
        data() {
            return {
                notificaciones: [],
                total: 0
            }
        },    
        methods:{
            cambiarMenu(){
                this.$root.menu=20;
            },
            listarNotificaciones (){
                let me=this;
                axios.get('/notificaciones/2').then(function (response) {
                    me.total = response.data.alertas.length;
                    me.notificaciones = response.data.alertas.splice(0, 5);
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            leerNotificacion(id){
                let me = this;

                axios.post('/notificacion/leer',{
                    'id': id
                }).then(function (response) {
                    me.listarNotificaciones();

                    Vue.$toast.open({
                        message: 'Notificación marcada como leída!',
                        type: 'success',
                        duration: 5000
                    });

                }).catch(function (error) {
                    console.error(error);
                });
            }
        },
        mounted() {
            this.listarNotificaciones();

            Event.$on('marcar', (id) => {
                this.listarNotificaciones();
            })
        }
    }
</script>