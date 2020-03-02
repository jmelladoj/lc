<template>
    <div class="page-wrapper">
        <b-container fluid class="mb-5">
            <b-row class="page-titles">
                <b-col xs="12" sm="12" md="5" class="align-self-center"><h4 class="text-themecolor">Avatares</h4></b-col>
                <b-col xs="12" sm="12" md="7">
                    <div class="d-flex justify-content-end align-items-right">
                        <sociales></sociales>
                        <b-button @click="abrirModal(1)" class="btn btn-success d-lg-block m-l-15" v-b-tooltip.hover title="Agrega una avatar a la plataforma"><i class="fa fa-plus-circle"></i> Agregar avatar</b-button>
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

                                <template v-slot:cell(dirigido)="data">
                                    <label v-if="data.item.tipo_persona == null">Todos</label>
                                    <label v-else-if="data.item.tipo_persona == 1">Personas</label>
                                    <label v-else-if="data.item.tipo_persona == 2">Pymes</label>
                                    <label v-else-if="data.item.tipo_persona == 3">Estudiantes</label>
                                </template>

                                <template v-slot:cell(seccion)="data">
                                    <label v-if="data.item.link == '/intranet/1'">Sección perfil</label>
                                    <label v-else-if="data.item.link == '/intranet/2'">Sección solicitar documento</label>
                                    <label v-else-if="data.item.link == '/intranet/3'">Sección sorteos</label>
                                    <label v-else-if="data.item.link == '/intranet/4'">Sección promociones</label>
                                    <label v-else-if="data.item.link == '/intranet/6'">Sección seminarios</label>
                                    <label v-else-if="data.item.link == '/intranet/7'">Sección terreno</label>
                                    <label v-else-if="data.item.link == '/intranet/8'">Sección recomiéndanos</label>
                                    <label v-else-if="data.item.link == '/intranet/11'">Sección subir documento</label>
                                    <label v-else-if="data.item.link == '/intranet/12'">Sección recargar</label>
                                </template>

                                <template v-slot:cell(imagen)="data">
                                    <b-img :src="'storage/' + data.item.url_imagen" fluid center alt="avatar" height="150" class="imagen"></b-img>
                                </template>

                                <template v-slot:cell(acciones)="row">
                                    <b-button size="xs" variant="danger" title="Eliminar avatar" @click="borrar(row.item.id)">
                                        <i class="fa fa-trash"></i>
                                    </b-button>
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

            <ValidationObserver ref="observer_avatar" v-slot="{ valid }">
                <b-modal ref="modal_avatar" :title="modal_avatar.titulo" no-close-on-backdrop scrollable>
                    <b-form>
                        <b-form-group>
                            <ValidationProvider name="Nombre" rules="required|min:3" v-slot="{ errors }">
                                <b-form-input type="text" v-model="avatar.nombre" placeholder="Título"></b-form-input>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>


                        <b-form-group label="Imagen (1080px alto como minímo | JPG, JPEG y PNG)">
                            <ValidationProvider name="imagen" rules="required" v-slot="{ errors, validate }">
                                <b-img v-if="avatar.url_imagen != null" :src="avatar.url_imagen" fluid id="img_avatar" center name="img_avatar" class="imagen"></b-img>
                                <b-form-file id="imagen_avatar" name="imagen_avatar" accept="image/*" placeholder="Sin archivo" @change="mostrarFoto($event)" @input="validate"></b-form-file>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group>
                    </b-form>

                    <template slot="modal-footer">
                        <div class="w-100">
                            <b-spinner class="float-left" variant="success" label="Spinning" v-show="spinner.estado == 1"></b-spinner>

                            <b-button class="float-right" :disabled="!valid || modal_avatar.accion == 0" v-show="modal_avatar.accion == 1" size="md" variant="success" @click="crearOactualizar(1)"> Guardar </b-button>
                            <b-button class="float-right" v-show="modal_avatar.accion == 2" size="md" variant="warning" @click="crearOactualizar(2)"> Actualizar </b-button>
                            <b-button class="float-right" size="md" variant="danger" @click="cerrarModal()"> Cerrar </b-button>
                        </div>
                    </template>
                </b-modal>
            </ValidationObserver>
        </b-container>

    </div>
</template>

<script>
    const items = [];

    export default {
        data() {
            return {
                spinner: {
                    estado: 0
                },
                avatar: {
                    id: 0,
                    nombre: '',
                    url_imagen: null,
                },
                modal_avatar: {
                    titulo: '',
                    accion: 0
                },
                items: items,
                fields: [
                    { key: 'index', label: '#', sortable: true, sortDirection: 'desc', class: 'text-center' },
                    { key: 'nombre', label: 'Nombre', sortable: true, class: 'text-left' },
                    { key: 'imagen', label: 'Imagen', sortable: true, class: 'text-center' },
                    { key: 'acciones', label: 'Acciones', sortable: true, class: 'text-center' }
                ],
                currentPage: 1,
                perPage: 10,
                totalRows: 0,
                pageOptions: [10, 25, 50, 100],
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',
                filter: null
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
            mostrarFoto(e){
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagen_avatar').attr('src', e.target.result);
                }

                if(e.target.files[0]){
                    reader.readAsDataURL(e.target.files[0]);
                    this.avatar.url_imagen = URL.createObjectURL(e.target.files[0]);
                }
            },
            listar_avatares (){
                let me=this;
                axios.get('/avatares').then(function (response) {
                    me.items = response.data.avatares;
                    me.totalRows = me.items.length;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            crearOactualizar(accion){
                let me = this;

                let formData = new FormData();
                let imagen_avatar = document.querySelector('#imagen_avatar');
                me.spinner.estado = 1;
                me.modal_avatar.accion = 0;

                formData.append('imagen_avatar', imagen_avatar.files[0]);

                formData.append('avatar_id', this.avatar.id);
                formData.append('nombre', this.avatar.nombre);

                axios.post('avatar/crear/actualizar',formData).then(function (response) {
                    me.listar_avatares();
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
            borrar(id){
                Swal.fire({
                    title: '¿Deseas borrar el avatar?',
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
                        axios.post('/avatar/eliminar',{
                            'id': id
                        }).then(function (response) {
                            me.listar_avatares();

                            Vue.$toast.open({
                                message: 'El avatar ha sido borrado!',
                                type: 'success',
                                duration: 5000
                            });

                        }).catch(function (error) {
                            console.log(error);
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {}
                })
            },
            cerrarModal(){
                this.modal_avatar.titulo = "";
                this.modal_avatar.accion = 0;
                this.spinner.estado = 0;
                this.$refs['modal_avatar'].hide();
            },
            abrirModal(accion, data = []){
                let me = this;
                this.limpiarDatosavatar();

                if(accion == 1){
                    me.modal_avatar.titulo = "Agregar avatar";
                    me.modal_avatar.accion = 1;
                } else if(accion == 2){
                    me.modal_avatar.titulo = "Modificar avatar";
                    me.modal_avatar.accion = 2;

                    me.avatar.id = data.id;
                    me.avatar.nombre = data.nombre;
                    me.avatar.url_imagen = 'storage/' + data.url_imagen;
                }

                this.$refs['modal_avatar'].show();
            },
            limpiarDatosavatar(){
                this.avatar.id = 0;
                this.avatar.nombre = '';
                this.avatar.url_imagen = null;
            }
        },
        mounted() {
            this.listar_avatares();
        }
    }
</script>

<style>
    .vue-swatches__wrapper {
        width: auto !important;
    }

    .vue-swatches__fallback__wrapper {
        width: auto !important;
    }

    .vue-swatches__swatch {
        height: 30px !important;
        width: 30px !important;
    }


    select option:hover, select option:focus, select option:active, select option:checked{
        background-color: #E8ECD1 !important;
    }

    .custom-file:focus, .custom-file:focus{
        border-color: #8AB733;
        outline: 0;
        box-shadow: 0 0 0 1px rgba(138, 183, 51);
    }

</style>
