<template>
    <b-row>
        <b-col cols="4">
            <b-card>
                <center class="mt-1">
                    <ValidationObserver ref="observer_foto_perfil"> 
                        <b-form-group v-show="tipo_usuario_logeado == 2">
                            <div class="custom-control custom-checkbox">
                                <b-form-checkbox v-model="usuario.top_five">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ¡Quiero ser aparecer en el top five!</b-form-checkbox>
                            </div>
                        </b-form-group >          
                        <img v-bind:src="usuario.url_perfil" alt="Imagen de usuario" class="img-circle" width="150">
                        <b-form-group  class="mt-3 mb-3">
                            <ValidationProvider name="imagen" rules="required|image" v-slot="{ errors, validate }">
                                <b-form-file v-show="tipo_usuario_logeado < 4" id="img_perfil" ref="file-input" name="img_perfil" accept="image/*" placeholder="Sin archivo" class="input-lg" @change="cambiarFoto(1)" @input="validate"></b-form-file>
                                <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                            </ValidationProvider>
                        </b-form-group >
                        <b-form-group v-show="tipo_usuario_logeado < 4">
                            <b-button variant="danger" @click="cambiarFoto(2)" class="btn-block"  title="Elimina tu imagen de perfil">Eliminar imagen</b-button>
                        </b-form-group >
                        <h4 class="card-title m-t-10" v-text="usuario.nombre"></h4>
                        <h6 class="card-subtitle" v-text="categoria.nombre + ' - ' + categoria.nivel"></h6>
                        <h6 class="card-subtitle" v-if="usuario.tipo_persona == 1"> Persona</h6>
                        <h6 class="card-subtitle" v-else-if="usuario.tipo_persona == 2"> Pyme</h6>
                        <h6 class="card-subtitle" v-else-if="usuario.tipo_persona == 3"> Estudiante</h6>
                        <hr>
                        <small class="text-muted">Correo: </small><h6 v-text="usuario.email"></h6>
                    </ValidationObserver>
                </center>
            </b-card>
        </b-col>
        <b-col cols="8">
            <b-card>
                <b-tabs v-if="usuario.tipo_persona != 2" content-class="mt-3">
                    <ValidationObserver ref="observer_usuario" v-slot="{ valid }">
                        <b-tab title="Datos personales" active>
                            <b-form-group v-show="tipo_usuario_logeado < 3" label="Tipo de usuario">
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
                            <b-row>
                                <b-col>
                                    <b-form-group label="Nombre completo">
                                        <ValidationProvider name="nombre" rules="required|min:3|alpha_spaces" v-slot="{ errors }">
                                            <b-form-input type="text" v-model="usuario.nombre" :readonly="tipo_usuario_logeado >= 3"></b-form-input>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group label="Run / rut usuario">
                                        <ValidationProvider name="run / rut" rules="required|min:3" v-slot="{ errors }">
                                            <input type="text" v-rut v-model="usuario.run" class="form-control" :readonly="tipo_usuario_logeado >= 3" />
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row v-show="tipo_usuario_logeado < 4">
                                <b-col>
                                    <b-form-group label="Email">
                                        <ValidationProvider name="email" rules="required|email" v-slot="{ errors }">
                                            <b-form-input type="email" v-model="usuario.email" :readonly="tipo_usuario_logeado >= 3"></b-form-input>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group label="Cambiar contraseña">
                                        <ValidationProvider name="contraseña" rules="min:6" v-slot="{ errors }">
                                            <b-form-input type="password" v-model="usuario.password"></b-form-input>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col>
                                    <b-form-group label="Fecha de nacimiento">
                                        <ValidationProvider name="fecha de nacimiento" rules="required" v-slot="{ errors }">
                                            <b-form-input type="date" v-model="usuario.fecha_nacimiento" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group label="Teléfono">
                                        <ValidationProvider name="teléfono" rules="required|numeric|digits:9" v-slot="{ errors }">
                                            <b-form-input type="number" v-model="usuario.telefono" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col>
                                    <b-form-group label="Dirección">
                                        <ValidationProvider name="dirección" rules="required" v-slot="{ errors }">
                                            <b-form-input type="text" v-model="usuario.direccion" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group label="Comuna">
                                        <ValidationProvider name="comuna" rules="required" v-slot="{ errors }">
                                            <b-form-select v-model="usuario.comuna_id" :disabled="tipo_usuario_logeado == 4">
                                                <option :value="0" selected>Seleccionar una opción</option>
                                                <option v-for="(comuna, index) in comunas" :key="index" :value="comuna.id" v-text="comuna.nombre"></option>
                                            </b-form-select>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col>
                                    <b-form-group label="Estado civil">
                                        <ValidationProvider name="estado civil" rules="required|alpha_spaces" v-slot="{ errors }">
                                            <b-form-input type="text" v-model="usuario.estado_civil" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group label="¿Hijos? (rellenar con 0 en caso de que no)">
                                        <ValidationProvider name="hijos" rules="required|numeric|min:0" v-slot="{ errors }">
                                            <b-form-input type="number" v-model="usuario.hijos" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col>
                                    <b-button v-show="tipo_usuario_logeado < 4" :disabled="!valid" @click="actualizar()" class="btn btn-success btn-block" title="Actualiza información de tu perfil">Actualizar mi perfil</b-button>
                                </b-col>
                            </b-row>
                        </b-tab>
                    </ValidationObserver>

                    <ValidationObserver ref="observer_usuario_academico" v-slot="{ valid }">
                        <b-tab title="Datos acádemicos">
                            <b-row>
                                <b-col>
                                    <b-form-group :label="labels.casa_estudio">
                                        <ValidationProvider name="casa de estudio" rules="required|min:3|alpha_spaces" v-slot="{ errors }">
                                            <b-form-input type="text" v-model="usuario.casa_estudio" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group :label="labels.ramo_favorito">
                                        <ValidationProvider name="ramo favorito" rules="required|min:3" v-slot="{ errors }">
                                            <b-form-input type="text" v-model="usuario.ramo_favorito" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col>
                                    <b-form-group :label="labels.ramo_odiado">
                                        <ValidationProvider name="ramo menos favorito" rules="required|min:3" v-slot="{ errors }">
                                            <b-form-input type="text" v-model="usuario.ramo_odiado" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group :label="labels.titulo">
                                        <ValidationProvider name="título" rules="required|min:3" v-slot="{ errors }">
                                            <b-form-input type="text" v-model="usuario.titulo" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col>
                                    <b-form-group :label="labels.fecha_titulo">
                                        <ValidationProvider name="fecha" rules="required" v-slot="{ errors }">
                                            <b-form-input type="date" v-model="usuario.fecha_titulo" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group v-if="usuario.tipo_persona == 1" :label="labels.seremi_o_practica">
                                        <ValidationProvider name="fecha" rules="required" v-slot="{ errors }">
                                            <b-form-input type="date" v-model="usuario.seremi_o_practica" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                    <b-form-group v-else-if="usuario.tipo_persona == 3" :label="labels.seremi_o_practica">
                                        <ValidationProvider name="práctica" rules="required" v-slot="{ errors }">
                                            <b-form-input type="text" v-model="usuario.seremi_o_practica" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col>
                                    <b-form-group :label="labels.software">
                                        <ValidationProvider name="detalle de software" rules="required|min:20|max:200" v-slot="{ errors }">
                                            <b-form-textarea v-model="usuario.software" placeholder="Escribe aquí ..." rows="3" max-rows="6" :readonly="tipo_usuario_logeado == 4"></b-form-textarea>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group :label="labels.experiencia">
                                        <ValidationProvider name="detalle de experiencia" rules="required|min:20|max:200" v-slot="{ errors }">
                                            <b-form-textarea v-model="usuario.experiencia" placeholder="Escribe aquí ..." rows="3" max-rows="6" :readonly="tipo_usuario_logeado == 4"></b-form-textarea>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col>
                                    <b-button v-show="tipo_usuario_logeado < 4" :disabled="!valid" @click="actualizar()" class="btn btn-success btn-block" title="Actualiza información de tu perfil">Actualizar mi perfil</b-button>
                                </b-col>
                            </b-row>
                        </b-tab>
                    </ValidationObserver>

                    <ValidationObserver ref="observer_usuario_ejercicio" v-slot="{ valid }">
                        <b-tab title="Datos del ejercicio">
                            <b-row>
                                <b-col>
                                    <b-form-group :label="labels.amigo">
                                        <ValidationProvider name="amigo" rules="min:20|max:200" v-slot="{ errors }">
                                            <b-form-textarea v-model="usuario.amigo" placeholder="Escribe aquí ..." rows="3" max-rows="6" :readonly="tipo_usuario_logeado == 4"></b-form-textarea>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row v-show="usuario.tipo_persona == 3">
                                <b-col>
                                    <b-form-group :label="labels.profesion">
                                        <ValidationProvider name="rubro" rules="required" v-slot="{ errors }">
                                            <b-form-select v-model="usuario.profesion_id" :disabled="tipo_usuario_logeado == 4">
                                                <option :value="0" selected>Seleccionar una opción</option>
                                                <option v-for="(profesion, index) in profesiones.filter(p => p.tipo_persona == usuario.tipo_persona)" :key="index" :value="profesion.id" v-text="profesion.nombre"></option>
                                            </b-form-select>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group :label="labels.otro_rubro">
                                        <ValidationProvider name="otro rubro" rules="required|min:3" v-slot="{ errors }">
                                            <b-form-input type="text" v-model="usuario.otro_rubro" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row v-show="usuario.tipo_persona == 1">
                                <b-col>
                                    <b-form-group :label="labels.profesion">
                                        <ValidationProvider name="rubro" rules="required" v-slot="{ errors }">
                                            <b-form-select v-model="usuario.profesion_id" :disabled="tipo_usuario_logeado == 4">
                                                <option :value="0" selected>Seleccionar una opción</option>
                                                <option v-for="(profesion, index) in profesiones.filter(p => p.tipo_persona == usuario.tipo_persona)" :key="index" :value="profesion.id" v-text="profesion.nombre"></option>
                                            </b-form-select>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group :label="labels.otro_rubro">
                                        <ValidationProvider name="otro rubro" rules="required|min:3" v-slot="{ errors }">
                                            <b-form-input type="text" v-model="usuario.otro_rubro" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group :label="labels.tiempo_experiencia">
                                        <ValidationProvider name="experiencia" rules="required|numeric|min_value:0" v-slot="{ errors }">
                                            <b-form-input type="number" v-model="usuario.tiempo_experiencia" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col>
                                    <b-form-group :label="labels.porcentaje">
                                        <ValidationProvider name="porcentaje terreno" rules="required|numeric|min_value:0|max_value:100" v-slot="{ errors }">
                                            <b-form-input type="number" v-model="usuario.porcentaje_terreno" placeholder="Porcentaje terreno" @keyup="calcularPorcentajeOficina()" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group label="Porcentaje oficina">
                                        <ValidationProvider name="porcentaje oficina" rules="required|numeric|min:0" v-slot="{ errors }">
                                            <b-form-input type="number" v-model="usuario.porcentaje_oficina" :readonly="true" placeholder="Porcentaje oficina"></b-form-input>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col>
                                    <b-form-group :label="labels.especializacion">
                                        <ValidationProvider name="especialización" rules="min:20|max:200" v-slot="{ errors }">
                                            <b-form-textarea v-model="usuario.especializacion" placeholder="Escribe aquí ..." rows="3" max-rows="6" :readonly="tipo_usuario_logeado == 4"></b-form-textarea>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col>
                                    <b-form-group :label="labels.habilidad_sobresaliente">
                                        <ValidationProvider name="habilidad sobresaliente" rules="required|min:3" v-slot="{ errors }">
                                            <b-form-input type="text" v-model="usuario.habilidad_sobresaliente" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group :label="labels.habilidad_mejora">
                                        <ValidationProvider name="habilidad a mejorar" rules="required|min:3" v-slot="{ errors }">
                                            <b-form-input type="text" v-model="usuario.habilidad_mejora" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row v-show="usuario.tipo_persona == 1">
                                <b-col>
                                    <b-form-group :label="labels.ultimo_trabajo">
                                        <ValidationProvider name="trabajo" rules="required|min:3" v-slot="{ errors }">
                                            <b-form-input type="text" v-model="usuario.ultimo_trabajo" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group :label="labels.ultimo_empresa">
                                        <ValidationProvider name="empresa" rules="required|min:3" v-slot="{ errors }">
                                            <b-form-input type="text" v-model="usuario.ultimo_empresa" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row v-show="usuario.tipo_persona == 1">
                                <b-col>
                                    <b-form-group :label="labels.rubro_empresa">
                                        <ValidationProvider name="trabajo" rules="required|min:3" v-slot="{ errors }">
                                            <b-form-input type="text" v-model="usuario.rubro_empresa" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group :label="labels.organismo_administrador_empresa">
                                        <ValidationProvider name="preferencia laboral" rules="required" v-slot="{ errors }">
                                            <b-form-select v-model="usuario.organismo_administrador_empresa" :disabled="tipo_usuario_logeado == 4">
                                                <option :value="0" selected>Seleccionar una opción</option>
                                                <option :value="1" selected>Mutual</option>
                                                <option :value="2" selected>ACHS</option>
                                                <option :value="3" selected>ILS</option>
                                                <option :value="4" selected>IST</option>                                                       
                                            </b-form-select>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col>
                                    <b-form-group :label="labels.preferencia_laboral">
                                        <ValidationProvider name="preferencia laboral" rules="required" v-slot="{ errors }">
                                            <b-form-select v-model="usuario.preferencia_laboral" :disabled="tipo_usuario_logeado == 4">
                                                <option :value="0" selected>Seleccionar una opción</option>
                                                <option :value="1" selected>Con trabajo fijo</option>
                                                <option :value="2" selected>Con trabajo part-time</option>
                                                <option :value="3" selected>Como asesor FreeLancer</option>
                                                <option :value="4" selected>¡A la espera de una oportunidad!</option>
                                                <option :value="5" selected>¡Quiero mi propia empresa!</option>
                                                
                                            </b-form-select>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group :label="labels.emprendimiento">
                                        <ValidationProvider name="emprendimiento" rules="required|min:3" v-slot="{ errors }">
                                            <b-form-input type="text" v-model="usuario.emprendimiento" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col>
                                    <b-form-group :label="labels.enterarse">
                                        <ValidationProvider name="enterarse" rules="required|min:20|max:200" v-slot="{ errors }">
                                            <b-form-textarea v-model="usuario.enterarse" placeholder="Escribe aquí ..." rows="3" max-rows="6" :readonly="tipo_usuario_logeado == 4"></b-form-textarea>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group :label="labels.coaching">
                                        <ValidationProvider name="coaching" rules="required|min:20|max:200" v-slot="{ errors }">
                                            <b-form-textarea v-model="usuario.coaching" placeholder="Escribe aquí ..." rows="3" max-rows="6" :readonly="tipo_usuario_logeado == 4"></b-form-textarea>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col>
                                    <b-button v-show="tipo_usuario_logeado < 4" :disabled="!valid" @click="actualizar()" class="btn btn-success btn-block" title="Actualiza información de tu perfil">Actualizar mi perfil</b-button>
                                </b-col>
                            </b-row>
                        </b-tab>
                    </ValidationObserver>
                </b-tabs>

                <b-tabs v-else class="nav nav-tabs profile-tab" content-class="mt-3" fill>
                    <b-tab title="Datos comerciales" active>
                        <b-card-text>Tab Contents 1</b-card-text>
                    </b-tab>
                    <b-tab title="Datos acádemicos">
                        <b-card-text>Datos de pyme</b-card-text>
                    </b-tab>
                </b-tabs>

            </b-card>
        </b-col>
    </b-row>
</template>

<script>
    export default {
        props: [
            'usuario_id', 'tipo_usuario_logeado'
        ],
        data() {
            return {
                usuario: {
                    id: 0,
                    nombre: '',
                    run: '',
                    email: '',
                    password: '',
                    url_perfil: '',
                    tipo_usuario: 0,
                    tipo_persona: 0,
                    fecha_nacimiento: '',
                    telefono: null,
                    direccion: '',
                    comuna_id: 0,
                    hijos: 0,
                    estado_civil: '',
                    casa_estudio: '',
                    ramo_favorito: '',
                    ramo_odiado: '',
                    titulo: '',
                    fecha_titulo: '',
                    seremi_o_practica: '',
                    software: '',
                    experiencia: '',
                    amigo: '',
                    profesion_id: 0,
                    otro_rubro: '',
                    porcentaje_terreno: 0,
                    porcentaje_oficina: 0,
                    especializacion: '',
                    habilidad_sobresaliente: '',
                    habilidad_mejora: '',
                    preferencia_laboral: 0,
                    emprendimiento: '',
                    enterarse: '',
                    coaching: '',
                    tiempo_experiencia: 0,
                    ultimo_trabajo: '',
                    ultimo_empresa: '',
                    rubro_empresa: '',
                    organismo_administrador_empresa: 0,
                    top_five: false
                },
                categoria: {
                    nombre: '',
                    nivel: ''
                },
                labels: {
                    casa_estudio: '',
                    ramo_favorito: '',
                    ramo_odiado: '',
                    titulo: '',
                    fecha_titulo: '',
                    seremi_o_practica: '',
                    software: '',
                    experiencia: '',
                    amigo: '',
                    profesion: '',
                    otro_rubro: '',
                    porcentaje: '',
                    especializacion: '',
                    habilidad_sobresaliente: '',
                    habilidad_mejora: '',
                    preferencia_laboral: '',
                    emprendimiento: '',
                    enterarse: '',
                    coaching: '',
                    tiempo_experiencia: '',
                    ultimo_trabajo: '',
                    ultimo_empresa: '',
                    rubro_empresa: '',
                    organismo_administrador_empresa: ''
                },
                comunas: [],
                profesiones: []
            }
        },    
        methods:{
            mostrarLabels(){
                let me = this;

                switch (me.usuario.tipo_persona) {
                    case 1:
                        //Persona
                        me.labels.casa_estudio = '¿Cuál fue tu casa de estudios?';
                        me.labels.ramo_favorito = '¿Cuál fue tu ramo favorito?';
                        me.labels.ramo_odiado = '¿Cuál fue tu ramo menos favorito?';
                        me.labels.titulo = '¿Cuál es tu título?';
                        me.labels.fecha_titulo = '¿Cuál es la fecha del certificado de título?';
                        me.labels.seremi_o_practica = '¿Cuál es la fecha de tu Registro Seremi?';                      
                        me.labels.profesion = '¿Cuál es tu rubro con mayor experiencia?';
                        me.labels.tiempo_experiencia = 'En total, ¿cuántos años haz ejercido?';
                        me.labels.ultimo_trabajo = 'Describe brevemente tu actual o el último cargo y el logro o habilidad que desarrollaste mientras lo ejerces o lo ejerciste.';
                        me.labels.ultimo_empresa = '¿Cuál es el nombre de tu actual empresa o la última donde trabajaste?';
                        me.labels.rubro_empresa = '¿cuál es el rubro principal de esa Empresa?';
                        me.labels.organismo_administrador_empresa = '¿Cuál es el organismo administrador de esa empresa?';
                        break;
                    case 3:
                        //Estudiante
                        me.labels.casa_estudio = '¿Cuál es tu casa de estudios?';
                        me.labels.ramo_favorito = '¿Cuál es tu ramo favorito?';
                        me.labels.ramo_odiado = '¿Cuál es tu ramo menos favorito?';
                        me.labels.titulo = '¿Cuál es el título que obtendrás?';
                        me.labels.fecha_titulo = '¿En que fecha obtendrás tu certificado de título?';
                        me.labels.seremi_o_practica = '¿Dónde realizarás tu práctica profesional?';
                        me.labels.profesion = '¿Cuál es el rubro que te llama la atención?';
                        
                        break;
                    case 2:
                        //Pyme
                        //Declaraciones ejecutadas cuando el resultado de expresión coincide con valorN
                        break
                }

                me.labels.software = '¿Qué tipos de softwares utilizas y cuál es tu nivel de experiencia con ellos?';
                me.labels.experiencia = 'Háblanos un poco de tu experiencia';
                me.labels.amigo = '¿Tienes algún amigo que se relacion con la prevención?. ¡Cuéntanos quién es!';
                me.labels.otro_rubro = '¿Algún otro rubro?';
                me.labels.porcentaje = '¿Cuál es tu preferencia en el ejercicio de la profesión?';
                me.labels.especializacion = 'Descríbe tus especializaciones';
                me.labels.habilidad_sobresaliente = 'Describe brevemente una habilidad sobresaliente';
                me.labels.habilidad_mejora = 'Describe brevemente una habilidad a mejorar';
                me.labels.preferencia_laboral = '¿Cuál es tu preferencia laboral?';
                me.labels.emprendimiento = '¿Tienes algún emprendimiento?';
                me.labels.enterarse = '¿Cómo se enteró del sitio web Prevención LebenCo.?';
                me.labels.coaching = '¿Le gustaría obtener coaching para desarrollar su potencial y diferenciarse de sus futuros colegas? ';
            },
            listarComunas (){
                let me=this;
                axios.get('/comunas').then(function (response) {
                    me.comunas = response.data.comunas;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listarUsuario (){
                let me = this;

                axios.get('/usuario/' + this.usuario_id).then(function (response) {
                    //Datos usuario
                    me.usuario.id = response.data.usuario.id;
                    me.usuario.nombre = response.data.usuario.nombre;
                    me.usuario.run = response.data.usuario.run;
                    me.usuario.email = response.data.usuario.email;
                    me.usuario.url_perfil = response.data.usuario.url_perfil == 'img/perfil.svg' ?  response.data.usuario.url_perfil : 'storage/' + response.data.usuario.url_perfil;
                    me.usuario.tipo_usuario = response.data.usuario.tipo_usuario;
                    me.usuario.tipo_persona = response.data.usuario.tipo_persona;
                    me.usuario.fecha_nacimiento = response.data.usuario.id;
                    me.usuario.telefono = response.data.usuario.telefono;
                    me.usuario.direccion = response.data.usuario.direccion;
                    me.usuario.comuna_id = response.data.usuario.comuna_id == null ? 0 : response.data.usuario.comuna_id;
                    me.usuario.hijos = response.data.usuario.hijos;
                    me.usuario.estado_civil = response.data.usuario.estado_civil;
                    me.usuario.casa_estudio = response.data.usuario.casa_estudio;
                    me.usuario.ramo_favorito = response.data.usuario.ramo_favorito;
                    me.usuario.ramo_odiado = response.data.usuario.ramo_odiado;
                    me.usuario.titulo = response.data.usuario.titulo;
                    me.usuario.fecha_titulo = response.data.usuario.fecha_titulo;
                    me.usuario.seremi_o_practica = response.data.usuario.seremi_o_practica;
                    me.usuario.software = response.data.usuario.software;
                    me.usuario.experiencia = response.data.usuario.experiencia;
                    me.usuario.amigo = response.data.usuario.amigo;
                    me.usuario.profesion_id = response.data.usuario.profesion_id == null ? 0 : response.data.usuario.profesion_id;
                    me.usuario.otro_rubro = response.data.usuario.otro_rubro;
                    me.usuario.porcentaje_terreno = response.data.usuario.porcentaje_terreno;
                    me.usuario.porcentaje_oficina = response.data.usuario.porcentaje_oficina;
                    me.usuario.especializacion = response.data.usuario.especializacion;
                    me.usuario.habilidad_sobresaliente = response.data.usuario.habilidad_sobresaliente;
                    me.usuario.habilidad_mejora = response.data.usuario.habilidad_mejora;
                    me.usuario.preferencia_laboral = response.data.usuario.preferencia_laboral;
                    me.usuario.emprendimiento = response.data.usuario.emprendimiento;
                    me.usuario.enterarse = response.data.usuario.enterarse;
                    me.usuario.coaching = response.data.usuario.coaching;
                    me.usuario.tiempo_experiencia = response.data.usuario.tiempo_experiencia;
                    me.usuario.ultimo_trabajo = response.data.usuario.ultimo_trabajo;
                    me.usuario.ultimo_empresa = response.data.usuario.ultimo_empresa;
                    me.usuario.rubro_empresa = response.data.usuario.rubro_empresa;
                    me.usuario.organismo_administrador_empresa = response.data.usuario.organismo_administrador_empresa;
                    me.usuario.top_five = response.data.usuario.top_five;


                    //Datos categoria
                    me.categoria.id = response.data.usuario.categoria.id;
                    me.categoria.nombre = response.data.usuario.categoria.nombre;
                    me.categoria.nivel = response.data.usuario.categoria.nivel;

                    me.mostrarLabels();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listarProfesiones(){
                let me=this;
                axios.get('/profesiones/oficios/2').then(function (response) {
                    me.profesiones = response.data.profesiones;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            actualizar(){
                let me = this;

                axios.post('usuario/crear/actualizar',{
                    'usuario_id': me.usuario.id,
                    'nombre': me.usuario.nombre,
                    'run': me.usuario.run,
                    'email': me.usuario.email,
                    'password': me.usuario.password,
                    'tipo_usuario': me.usuario.tipo_usuario,
                    'tipo_persona': me.usuario.tipo_persona,
                    'fecha_nacimiento': me.usuario.fecha_nacimiento,
                    'telefono': me.usuario.telefono,
                    'direccion': me.usuario.direccion,
                    'comuna_id': me.usuario.comuna_id,
                    'hijos': me.usuario.hijos,
                    'estado_civil': me.usuario.estado_civil,
                    'casa_estudio': me.usuario.casa_estudio,
                    'ramo_favorito': me.usuario.ramo_favorito,
                    'ramo_odiado': me.usuario.ramo_odiado,
                    'titulo': me.usuario.titulo,
                    'fecha_titulo': me.usuario.fecha_titulo,
                    'seremi_o_practica': me.usuario.seremi_o_practica,
                    'software': me.usuario.software,
                    'experiencia': me.usuario.experiencia,
                    'amigo': me.usuario.amigo,
                    'profesion_id': me.usuario.profesion_id,
                    'otro_rubro': me.usuario.otro_rubro,
                    'otro_rubro': me.usuario.otro_rubro,
                    'porcentaje_terreno': me.usuario.porcentaje_terreno,
                    'porcentaje_oficina': me.usuario.porcentaje_oficina,
                    'especializacion': me.usuario.especializacion,
                    'habilidad_sobresaliente': me.usuario.habilidad_sobresaliente,
                    'habilidad_mejora': me.usuario.habilidad_mejora,
                    'preferencia_laboral': me.usuario.preferencia_laboral,
                    'emprendimiento': me.usuario.emprendimiento,
                    'enterarse': me.usuario.enterarse,
                    'coaching': me.usuario.coaching,
                    'tiempo_experiencia': me.usuario.tiempo_experiencia,
                    'ultimo_trabajo': me.usuario.ultimo_trabajo,
                    'ultimo_empresa': me.usuario.ultimo_empresa,
                    'rubro_empresa': me.usuario.rubro_empresa,
                    'organismo_administrador_empresa': me.usuario.organismo_administrador_empresa,
                    'top_five': me.usuario.top_five
                    
                }).then(function (response) {
                    me.listarUsuario();

                    Vue.$toast.open({
                        message: 'Registro actualizado exitosamente',
                        type: 'success',
                        duration: 5000
                    });

                }).catch(function (error) {
                    console.error(error);
                });
            },
            cambiarFoto(accion){
                let me = this;

                let formData = new FormData();

                if(accion == 1){
                    let img_perfil = document.querySelector('#img_perfil');
                    formData.append('img_perfil', img_perfil.files[0]);
                }
                
                formData.append('usuario_id', this.usuario.id);

                axios.post('usuario/actualizar/imagen',formData).then(function (response) {

                	Vue.$toast.open({
                        message: accion == 1 ? 'Foto actualizada exitosamente' : 'Foto eliminada exitosamente',
                        type: 'success',
                        duration: 5000
                    });

                    //if(accion == 1){
                    //    me.$refs['file-input'].reset();
                    //}

                    me.listarUsuario();
                }).catch(function (error) {
                    console.error(error);
                });
            },
            calcularPorcentajeOficina(){
                this.usuario.porcentaje_oficina = 100 - this.usuario.porcentaje_terreno;
            }
        },
       mounted() {
            this.listarComunas();
            this.listarUsuario();
            this.listarProfesiones();
        }
    }
</script>

<style>
    a:hover {
        color: #1E2F13;
    }

</style>