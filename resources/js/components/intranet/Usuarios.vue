<template>
    <div class="page-wrapper">
        <b-container fluid class="mb-5">
            <b-row class="page-titles">
                <b-col xs="12" sm="12" md="5" class="align-self-center"><h4 class="text-themecolor">Usuarios</h4></b-col>
                <b-col xs="12" sm="12" md="7">
                    <div class="d-flex justify-content-end align-items-right">
                        <sociales></sociales>
                        <b-button @click="abrirModal(1)" class="btn btn-success d-lg-block m-l-15" v-b-tooltip title="Agrega un usuario a la plataforma"><i class="fa fa-plus-circle"></i> Agregar Usuario</b-button>
                        <b-button @click="ir_tabla_vip()" class="btn btn-success d-lg-block m-l-15" v-b-tooltip title="Ir a tabla vip"><i class="fa fa-list"></i> Ir a tabla VIP</b-button>
                    </div>
                </b-col>
            </b-row>

            <b-row>
                <b-col>
                    <b-card>
                        <b-form-group>
                            <b-container fluid class="mb-5">
                                <b-row>
                                    <b-col md="4" class="my-1">
                                        <b-form-group label-cols-sm="3" label="Filtrar" class="mb-0">
                                        <b-input-group>
                                            <b-form-input v-model="filter" placeholder="Escribe para buscar" />
                                            <b-input-group-append>
                                            <b-button :disabled="!filter" @click="filter = ''">Limpiar</b-button>
                                            </b-input-group-append>
                                        </b-input-group>
                                        </b-form-group>
                                    </b-col>

                                    <b-col md="4" class="my-1">
                                        <b-form-group label-cols-sm="3" label="Ordenar" class="mb-0">
                                        <b-input-group>
                                            <b-form-select v-model="sortBy" :options="sortOptions">
                                            <option slot="first" :value="null">-- nada --</option>
                                            </b-form-select>
                                            <b-form-select :disabled="!sortBy" v-model="sortDesc" slot="append">
                                            <option :value="false">Asc</option> <option :value="true">Desc</option>
                                            </b-form-select>
                                        </b-input-group>
                                        </b-form-group>
                                    </b-col>

                                    <b-col md="4" class="my-1">
                                        <b-form-group label-cols-sm="4" label="Por página" class="mb-0">
                                        <b-form-select :options="pageOptions" v-model="perPage" />
                                        </b-form-group>
                                    </b-col>
                                </b-row>

                                <!-- Main table element -->
                                <b-table
                                    show-empty
                                    responsive
                                    striped
                                    borderless
                                    outlined
                                    small
                                    hover
                                    stacked="sm"
                                    :items="items"
                                    :fields="fields"
                                    :current-page="currentPage"
                                    :per-page="perPage"
                                    :filter="filter"
                                    :sort-by.sync="sortBy"
                                    :sort-desc.sync="sortDesc"
                                    :sort-direction="sortDirection"
                                    @filtered="onFiltered"
>

                                    <template slot="empty">
                                        <center><h5>No hay registros para mostrar.</h5></center>
                                    </template>

                                    <template slot="emptyfiltered">
                                        <center><h5>No hay registros que coincidan con su solicitud.</h5></center>
                                    </template>

                                    <template v-slot:cell(index)="data">
                                        {{ data.index + 1 }}
                                    </template>

                                    <template v-slot:cell(tipo)="data">
                                        <label v-if="data.item.tipo_persona == 1"> Persona </label>
                                        <label v-else-if="data.item.tipo_persona == 2"> Pyme </label>
                                        <label v-else-if="data.item.tipo_persona == 3"> Estudiante </label>
                                    </template>

                                    <template v-slot:cell(tipo_user)="data">
                                        <label v-if="data.item.tipo_usuario == 1"> Administrador </label>
                                        <label v-else-if="data.item.tipo_usuario == 2"> Co administrador </label>
                                        <label v-else-if="data.item.tipo_usuario == 3"> Usuario </label>
                                    </template>

                                    <template v-slot:cell(acciones)="row">
                                        <template v-if="row.item.top_five == 1">
                                            <b-button size="xs" title="Quitar de tabla vip" @click="agregarQuitarTablaVip(row.item.id, 1)" class="btn btn-danger">
                                                <i class="fa fa-star-o"></i>
                                            </b-button>
                                        </template>
                                        <template v-else>
                                            <b-button size="xs" title="Añadir a tabla vip" @click="agregarQuitarTablaVip(row.item.id, 2)" class="btn btn-success">
                                                <i class="fa fa-star"></i>
                                            </b-button>
                                        </template>

                                        <template v-if="row.item.comunidad_pyme == 1">
                                            <b-button size="xs" title="Quitar de comunidad pyme" @click="agregarQuitarComunidadPyme(row.item.id, 1)" class="btn btn-danger">
                                                <i class="fa fa-eye-slash"></i>
                                            </b-button>
                                        </template>
                                        <template v-else>
                                            <b-button size="xs" title="Añadir a comunidad pyme" @click="agregarQuitarComunidadPyme(row.item.id, 2)" class="btn btn-success">
                                                <i class="fa fa-eye"></i>
                                            </b-button>
                                        </template>

                                        <b-button size="xs" variant="success" title="Agregar saldo usuario" @click="abrirModalSaldo(row.item)">
                                            <i class="fa fa-usd"></i>
                                        </b-button>

                                        <b-button size="xs" variant="warning" title="Actualizar usuario" @click="abrirModal(2, row.item)">
                                            <i class="fa fa-pencil"></i>
                                        </b-button>

                                        <template>
                                            <b-button v-if="row.item.lista_negra" size="xs" variant="warning" title="Quitar de black list" @click="agregarOquitarBlacklist(row.item.id, 2)">
                                                <i class="fa fa-check"></i>
                                            </b-button>

                                            <b-button v-else size="xs" variant="danger" title="Añadir a black list" @click="agregarOquitarBlacklist(row.item.id, 1)">
                                                <i class="fa fa-times"></i>
                                            </b-button>
                                        </template>


                                        <template>
                                            <b-button v-if="row.item.deleted_at" size="xs" variant="warning" title="Restaurar usuario" @click="borrarOrestaurar(row.item.id, 2)">
                                                <i class="fa fa-undo"></i>
                                            </b-button>

                                            <b-button v-else size="xs" variant="danger" title="Eliminar usuario" @click="borrarOrestaurar(row.item.id, 1)">
                                                <i class="fa fa-trash"></i>
                                            </b-button>
                                        </template>
                                    </template>

                                </b-table>

                                <b-row>
                                    <b-col>
                                        <b-pagination :total-rows="totalRows" :per-page="perPage" v-model="currentPage" class="my-3" align="fill"/>
                                    </b-col>
                                </b-row>
                            </b-container>
                        </b-form-group>
                    </b-card>
                </b-col>
            </b-row>

            <ValidationObserver ref="observer_usuario" v-slot="{ valid }">
                <b-modal ref="modal_usuario" :title="modal_usuario.titulo" size="xl" no-close-on-backdrop>
                    <b-form v-if="modal_usuario.accion == 1">
                        <b-row>
                            <b-col xs="12" sm="12" md="6">
                                <b-form-group label="Nombre de Usuario">
                                    <ValidationProvider name="nombre" rules="required|min:3|alpha_spaces" v-slot="{ errors }">
                                        <b-form-input type="text" v-model="usuario.nombre"></b-form-input>
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </b-form-group>
                            </b-col>
                            <b-col xs="12" sm="12" md="6">
                                <b-form-group label="Run / rut usuario">
                                    <ValidationProvider name="run / rut" rules="required|min:3" v-slot="{ errors }">
                                        <input type="text" v-rut v-model="usuario.run" class="form-control" />
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </b-form-group>
                            </b-col>
                        </b-row>

                        <b-row>
                            <b-col xs="12" sm="12" md="6">
                                <b-form-group label="Email">
                                    <ValidationProvider name="email" rules="required|email" v-slot="{ errors }">
                                        <b-form-input type="email" v-model="usuario.email"></b-form-input>
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </b-form-group>
                            </b-col>
                            <b-col xs="12" sm="12" md="6">
                                <b-form-group label="Contraseña">
                                    <ValidationProvider name="contraseña" rules="required|min:6" v-slot="{ errors }">
                                        <b-form-input type="password" v-model="usuario.password"></b-form-input>
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </b-form-group>
                            </b-col>
                        </b-row>

                        <b-row>
                            <b-col xs="12" sm="12" md="6">
                                <b-form-group label="Tipo de usuario">
                                    <ValidationProvider name="tipo de usuario" rules="required|oneOf:1,2,3" v-slot="{ errors }">
                                        <b-form-select v-model="usuario.tipo_usuario">
                                            <option :value="0">Selecciona una opción</option>
                                            <option :value="1">Administrador</option>
                                            <option :value="2">Sub administrador</option>
                                            <option :value="3">Usuario normal</option>
                                        </b-form-select>
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </b-form-group>
                            </b-col>
                        </b-row>
                    </b-form>

                    <b-form v-if="modal_usuario.accion == 2">
                        <perfil_usuario :usuario_id="usuario.id" :tipo_usuario_logeado="1"></perfil_usuario>
                    </b-form>

                    <template slot="modal-footer">
                        <b-button :disabled="!valid" v-show="modal_usuario.accion == 1" size="md" variant="success" @click="crearOactualizar(1)"> Guardar </b-button>
                        <b-button size="md" variant="danger" @click="cerrarModal()"> Cerrar </b-button>
                    </template>
                </b-modal>
            </ValidationObserver>

            <ValidationObserver ref="observer_saldo" v-slot="{ valid }">
                <b-modal ref="modal_saldo" :title="modal_saldo.titulo" size="lg" no-close-on-backdrop>
                    <b-form>
                        <b-row>
                            <b-col xs="12" sm="12" md="6">
                                <b-form-group label="Saldo Actual">
                                    <b-form-input type="number" v-model="usuario.saldo_actual" readonly=""></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col xs="12" sm="12" md="6">
                                <b-form-group label="Saldo a añadir">
                                    <ValidationProvider name="saldo a añadir" rules="required|min_value:0|numeric" v-slot="{ errors }">
                                        <b-form-input type="number" v-model="usuario.nuevo_saldo"></b-form-input>
                                        <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                    </ValidationProvider>
                                </b-form-group>
                            </b-col>
                        </b-row>
                    </b-form>

                    <template slot="modal-footer">
                        <b-button :disabled="!valid" size="md" variant="success" @click="agregarSaldo()"> Guardar </b-button>
                        <b-button size="md" variant="danger" @click="cerrarModalSaldo()"> Cerrar </b-button>
                    </template>
                </b-modal>
            </ValidationObserver>
        </b-container>

    </div>
</template>

<script>

    export default {
        data() {
            return {
                usuario: {
                    id: 0,
                    nombre: '',
                    run: '',
                    email: '',
                    password: '',
                    tipo_usuario: 0,
                    saldo_actual: 0,
                    nuevo_saldo: 0,
                    posicion: 0,
                    posicion_actual: 0,
                    likes: 0,
                    dislikes: 0
                },
                modal_usuario: {
                    titulo: '',
                    accion: 0
                },
                modal_saldo: {
                    titulo: ''
                },
                modal_posicion: {
                    titulo: 'Asignar posición'
                },
                items: [],
                subusuarios: [],
                fields: [
                    { key: 'index', label: '#', sortable: true, sortDirection: 'desc', class: 'text-center' },
                    { key: 'run', label: 'Run', sortable: true, class: 'text-left' },
                    { key: 'nombre', label: 'Nombre', sortable: true, class: 'text-left' },
                    { key: 'email', label: 'Email', sortable: true, class: 'text-left' },
                    { key: 'tipo_user', label: 'Tipo usuario', sortable: true, class: 'text-left' },
                    { key: 'tipo', label: 'Tipo persona', sortable: true, class: 'text-left' },
                    { key: 'acciones', label: 'Acciones', sortable: true, class: 'text-center' }
                ],
                currentPage: 1,
                perPage: 10,
                totalRows: 0,
                pageOptions: [10, 25, 50, 100],
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',
                filter: null,
            }
        },
        computed:{
            sortOptions() {
                return this.fields.filter(f => f.sortable).map(f => {
                    return { text: f.label, value: f.key }
                })
            }
        },
        methods:{
            onFiltered(filteredItems) {
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },
            listarUsuarios(){
                let me=this;
                axios.get('/usuarios/1').then(function (response) {
                    me.items = response.data.usuarios;
                    me.totalRows = me.items.length;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            crearOactualizar(accion){
                let me = this;

                axios.post('usuario/crear/actualizar',{
                    'usuario_id': me.usuario.id,
                    'nombre': me.usuario.nombre,
                    'run': me.usuario.run,
                    'email': me.usuario.email,
                    'password': me.usuario.password,
                    'tipo_usuario': me.usuario.tipo_usuario
                }).then(function (response) {
                    me.listarUsuarios();
                    me.cerrarModal();
                    var mensaje = accion == 1 ? 'Registro agregado exitosamente' : 'Registro actualizado exitosamente';

                    Vue.$toast.open({
                        message: mensaje,
                        type: 'success',
                        duration: 5000
                    });

                }).catch(function (error) {
                    console.error(error);
                });
            },
            agregarSaldo(){
                let me = this;

                axios.post('/usuario/saldo',{
                    'usuario_id': me.usuario.id,
                    'nuevo_saldo': me.usuario.nuevo_saldo
                }).then(function (response) {
                    me.listarUsuarios();
                    me.cerrarModalSaldo();

                    Vue.$toast.open({
                        message: 'Saldo actualizado exitosamente!',
                        type: 'success',
                        duration: 5000
                    });

                }).catch(function (error) {
                    console.error(error);
                });
            },
            borrarOrestaurar(id, accion){
                var mensaje = accion == 2 ? '¿Deseas restaurar el usuario?' : '¿Deseas borrar el usuario?';
                Swal.fire({
                    title: mensaje,
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#8AB733',
                    cancelButtonColor: '#d7552a',
                    confirmButtonText: 'Aceptar!',
                    cancelButtonText: 'Cancelar',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                }).then((result) => {
                    if (result.value) {
                        let me = this;

                        var url = accion == 2 ? '/usuario/restaurar' : '/usuario/eliminar';
                        axios.post(url,{
                            'id': id
                        }).then(function (response) {
                            var mensaje = accion == 2 ? 'El usuario ha sido restaurado!' : 'El usuario ha sido quitado!';
                            me.listarUsuarios();

                            Vue.$toast.open({
		                        message: mensaje,
		                        type: 'success',
		                        duration: 5000
		                    });

                        }).catch(function (error) {
                            console.log(error);
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {}
                })
            },
            agregarOquitarBlacklist(id, accion){
                var mensaje = accion == 2 ? '¿Deseas quitar de la black list al usuario?' : '¿Deseas añadir a la black list el usuario?';
                Swal.fire({
                    title: mensaje,
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#8AB733',
                    cancelButtonColor: '#d7552a',
                    confirmButtonText: 'Aceptar!',
                    cancelButtonText: 'Cancelar',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                }).then((result) => {
                    if (result.value) {
                        let me = this;

                        var url = accion == 2 ? '/usuario/blacklist/quitar' : '/usuario/blacklist/agregar';
                        axios.post(url,{
                            'id': id
                        }).then(function (response) {
                            var mensaje = accion == 2 ? 'El usuario ha sido quitado de la black list!' : 'El usuario ha sido añadido a la black list!';
                            me.listarUsuarios();

                            Vue.$toast.open({
		                        message: mensaje,
		                        type: 'success',
		                        duration: 5000
		                    });

                        }).catch(function (error) {
                            console.log(error);
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {}
                })
            },
            agregarQuitarTablaVip(id, accion){
                let me = this
                
                var mensaje = accion == 2 ? '¿Deseas agregar a la tabla vip al usuario?' : '¿Deseas quitar de la tabla vip el usuario?';

                var url = accion == 2 ? '/usuario/tabla/vip/agregar' : '/usuario/tabla/vip/quitar';
                axios.post(url,{
                    'id': id
                }).then(function (response) {
                    var mensaje = accion == 2 ? 'El usuario ha sido agregado a la tabla vip!' : 'El usuario ha sido quitado a la tabla vip!';
                    me.listarUsuarios();

                    Vue.$toast.open({
                        message: mensaje,
                        type: 'success',
                        duration: 5000
                    });

                }).catch(function (error) {
                    console.log(error);
                });
            },
            agregarQuitarComunidadPyme(id, accion){
                let me = this

                var mensaje = accion == 2 ? '¿Deseas agregar de la tabla comunidad pyme al usuario?' : '¿Deseas quitar de la tabla comunidad pyme el usuario?';

                var url = accion == 2 ? '/usuario/comunidad/agregar' : '/usuario/comunidad/quitar';
                axios.post(url,{
                    'id': id
                }).then(function (response) {
                    var mensaje = accion == 2 ? 'El usuario ha sido agregado a la tabla comunidad pyme!' : 'El usuario ha sido quitado de la tabla comunidad pyme!';
                    me.listarUsuarios();

                    Vue.$toast.open({
                        message: mensaje,
                        type: 'success',
                        duration: 5000
                    });

                }).catch(function (error) {
                    console.log(error);
                });
            },
            cerrarModal(){
                this.modal_usuario.titulo = "";
                this.modal_usuario.accion = 0;
                this.$refs['modal_usuario'].hide();

                this.listarUsuarios()
            },
            cerrarModalSaldo(){
                this.modal_saldo.titulo = "";
                this.$refs['modal_saldo'].hide();
            },
            abrirModal(accion, data = []){
                let me = this;
                this.limpiarDatosUsuario();

                if(accion == 1){
                    me.modal_usuario.titulo = "Agregar Usuario";
                    me.modal_usuario.accion = 1;
                } else if(accion == 2){
                    me.modal_usuario.titulo = "Modificar Usuario";
                    me.modal_usuario.accion = 2;

                    me.usuario.id = data['id'];
                    me.usuario.nombre = data['nombre'];
                    me.usuario.run = data['run'];
                    me.usuario.email = data['email'];
                    me.usuario.password = data['password'];
                    me.usuario.tipo_usuario = data['tipo_usuario'];
                }

                this.$refs['modal_usuario'].show();
            },
            ir_tabla_vip(){
                this.$root.menu = 24
            },
            abrirModalSaldo(data = []){
                let me = this;

                me.limpiarDatosUsuario();
                me.modal_saldo.titulo = "Agregar saldo";
                me.usuario.id = data['id'];
                me.usuario.saldo_actual = data['saldo'];

                this.$refs['modal_saldo'].show();
            },
            abrirModalPosicion(data = []){
                let me = this;

                me.limpiarDatosUsuario();
                me.usuario.id = data['id'];
                me.usuario.posicion = data['posicion'];
                me.usuario.posicion_actual = me.usuario.posicion;
                me.usuario.likes = data['likes'];
                me.usuario.dislikes = data['dislikes'];

                this.$refs['modal_posicion'].show();
            },
            limpiarDatosUsuario(){
                this.usuario.id = 0;
                this.usuario.nombre = '';
                this.usuario.run = '';
                this.usuario.email = '';
                this.usuario.password = '';
                this.usuario.tipo_usuario = '';
                this.usuario.saldo_actual = 0;
                this.usuario.nuevo_saldo = 0;
            },
        },
        mounted() {
            this.listarUsuarios();
        }
    }
</script>

<style>
    .page-item.active .page-link {
        background-color:#8AB733;
        border-color:#8AB733;
    }

    .page-link:hover{
        color: #8AB733;
    }

    .page-link{
        color: #8AB733;
    }

    footer a {
        color: #8AB733;
    }
</style>
