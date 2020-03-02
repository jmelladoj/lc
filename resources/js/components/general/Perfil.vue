<template>
    <b-row>
        <b-col v-if="usuario.fecha_valida == 1" cols="12">
            <b-alert variant="warning" show>Su cuenta será cerrada por ser menor de edad, a exepción de que demuestre con documentos estar emancipado.</b-alert>
        </b-col>
        <b-col xs="12" sm="12" md="4">
            <b-card>
                <center class="mt-1">
                    <ValidationObserver ref="observer_foto_perfil">
                        <img v-bind:src="avatar_actual > 0 ? 'storage/' + usuario.url_perfil : usuario.url_perfil" alt="Imagen de usuario" class="img-circle" width="150">
                        <b-row  class="mt-2" v-if="avatares.length > 0">
                            <b-col>
                                <b-button variant="success" block @click="cambiar_avatar(1)">
                                    <i class="fa fa-arrow-left" aria-hidden="true"></i>
                                </b-button>
                            </b-col>
                            <b-col>
                                <b-button variant="warning" block v-show="avatar_actual > 0" @click="seleccionar_avatar">
                                    Seleccionar
                                </b-button>
                            </b-col>
                           <b-col>
                                <b-button variant="success" block @click="cambiar_avatar(2)">
                                    <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                </b-button>
                            </b-col>
                        </b-row>


                        <b-row class="mt-3">
                            <b-col cols="6">
                                <ValidationProvider name="imagen" rules="required|image" v-slot="{ errors, validate }">
                                    <b-form-file v-show="tipo_usuario_logeado < 4" id="img_perfil" ref="file-input" name="img_perfil" accept="image/*" placeholder="Sin archivo" class="input-lg" @change="cambiarFoto(1)" @input="validate"></b-form-file>
                                    <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                </ValidationProvider>
                            </b-col>
                            <b-col cols="6">
                                <b-form-group v-show="tipo_usuario_logeado < 4">
                                    <b-button variant="danger" @click="cambiarFoto(2)" class="btn-block"  title="Elimina tu imagen de perfil">Eliminar imagen</b-button>
                                </b-form-group >
                            </b-col>
                        </b-row>
                        <b-row v-show="tipo_usuario_logeado == 3">
                            <b-col cols="12">
                                <b-button v-if="usuario.tipo_persona != 2" :disabled="usuario.usuario_perfil == 0 || usuario.usuario_academico == 0 || usuario.usuario_ejercicio == 0" size="md" variant="success" block @click="comunidad_pyme(usuario.comunidad_pyme)">
                                    ¡Quiero ser conocido!
                                </b-button>
                                <b-button v-else :disabled="usuario.pyme_comercial == 0 || usuario.pyme_datos == 0" size="md" variant="success" block @click="comunidad_pyme(usuario.comunidad_pyme)">
                                    ¡Quiero ser conocido!
                                </b-button>
                            </b-col>
                            <b-col cols="12">
                                <b-button :disabled="usuario.presiona_tabla_vip  == 0" size="md" variant="warning" block @click="tabla_vip(usuario.top_five)">
                                    ¡Quiero ser recomendado!
                                </b-button>
                            </b-col>
                        </b-row>

                        <h4 class="card-title m-t-10" v-text="usuario.nombre"></h4>
                        <h6 class="card-subtitle" v-text="categoria.nombre + ' - ' + categoria.nivel"></h6>
                        <h6 class="card-subtitle" v-if="usuario.tipo_persona == 1"> Persona</h6>
                        <h6 class="card-subtitle" v-else-if="usuario.tipo_persona == 2"> Pyme</h6>
                        <h6 class="card-subtitle" v-else-if="usuario.tipo_persona == 3"> Estudiante</h6>

                        <p v-show="usuario.posicion > 0 && usuario.tipo_persona == 2">
                            <i class="fa fa-star fa-2x text-warning" aria-hidden="true" v-for="index in usuario.posicion" :key="index"></i>
                        </p>


                        <b-form-group v-show="usuario.tipo_usuario < 3">
                            <b-form-textarea v-model="usuario.descripcion_administrador" placeholder="Escribe aquí ..." rows="3" max-rows="6"></b-form-textarea>
                        </b-form-group>

                        <hr>
                        <small class="text-muted">Correo: </small><h6 v-text="usuario.email"></h6>
                    </ValidationObserver>
                </center>
            </b-card>
        </b-col>
        <b-col xs="12" sm="12" md="8">
            <b-card>
                <b-tabs v-if="usuario.tipo_persona != 2" content-class="mt-3">
                    <ValidationObserver ref="observer_usuario" v-slot="{ valid }">
                        <b-tab title="Datos personales" active>
                            <b-form-group v-show="tipo_usuario_logeado < 3" label="Tipo de usuario">
                                <ValidationProvider rules="oneOf:1,2,3" v-slot="{ errors }">
                                    <b-form-select v-model="usuario.tipo_usuario">
                                        <option :value="0">Selecciona una opción</option>
                                        <option :value="1">Administrador</option>
                                        <option :value="2">Sub administrador</option>
                                        <option :value="3">Usuario normal</option>
                                    </b-form-select>
                                    <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                </ValidationProvider>
                            </b-form-group>
                            <b-row>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="Nombre completo">
                                        <ValidationProvider rules="required|min:3|alpha_spaces" v-slot="{ errors }">
                                            <b-form-input type="text" v-model="usuario.nombre" :readonly="tipo_usuario_logeado >= 3"></b-form-input>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="RUN">
                                        <ValidationProvider rules="min:3" v-slot="{ errors }">
                                            <input type="text" v-rut v-model="usuario.run" class="form-control" :readonly="tipo_usuario_logeado >= 3" />
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row v-show="tipo_usuario_logeado < 4">
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="N° telefónico">
                                        <ValidationProvider rules="required|numeric|digits:8" v-slot="{ errors }">
                                            <b-input-group prepend="+56 9">
                                                <b-form-input type="text" v-model="usuario.telefono" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            </b-input-group>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="Correo electrónico">
                                        <ValidationProvider rules="email" v-slot="{ errors }">
                                            <b-form-input type="email" v-model="usuario.email" :readonly="tipo_usuario_logeado > 2"></b-form-input>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="Fecha de nacimiento">
                                        <ValidationProvider rules="required" v-slot="{ errors }">
                                            <b-form-input type="date" v-model="usuario.fecha_nacimiento" :readonly="tipo_usuario_logeado == 4" @change="validar_fecha"></b-form-input>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="Dirección">
                                        <ValidationProvider rules="required" v-slot="{ errors }">
                                            <b-form-input type="text" v-model="usuario.direccion" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="Comuna">
                                        <ValidationProvider rules="required" v-slot="{ errors }">
                                            <b-form-select v-model="usuario.comuna_id" :disabled="tipo_usuario_logeado == 4">
                                                <option :value="null" selected>Seleccionar una opción</option>
                                                <option v-for="(comuna, index) in comunas" :key="index" :value="comuna.id" v-text="comuna.nombre"></option>
                                            </b-form-select>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="Región">
                                        <ValidationProvider rules="required" v-slot="{ errors }">
                                            <b-form-select v-model="usuario.region">
                                                <option :value="null" selected>Seleccionar una opción</option>
                                                <option v-for="(region, index) in regiones" :key="index" :value="region.id" v-text="region.nombre"></option>
                                            </b-form-select>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="Situación sentimental">
                                        <ValidationProvider rules="required" v-slot="{ errors }">
                                            <b-form-select v-model="usuario.estado_civil" :disabled="tipo_usuario_logeado == 4">
                                                <option :value="null" selected>Seleccionar una opción</option>
                                                <option value="1">En una relación</option>
                                                <option value="2">¡Libre!</option>
                                                <option value="3">solter@</option>
                                                <option value="4">Casad@</option>
                                            </b-form-select>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="¿Tienes hij@s?">
                                        <b-row>
                                            <b-col xs="12" sm="12" md="6" class="mb-1">
                                                <b-form-radio-group id="radio-group-2" v-model="usuario.radio_hijos" name="radio-sub-component">
                                                    <b-form-radio value="0">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No</b-form-radio>
                                                    <b-form-radio value="1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sí</b-form-radio>
                                                </b-form-radio-group>
                                            </b-col>
                                            <b-col xs="12" sm="12" md="6">
                                                <ValidationProvider rules="required|numeric|min:0" v-slot="{ errors }">
                                                    <b-form-input type="number" v-model="usuario.hijos" :readonly="tipo_usuario_logeado == 4" v-show="usuario.radio_hijos == 1"></b-form-input>
                                                    <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                                </ValidationProvider>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="Cambiar contraseña (opcional)">
                                        <ValidationProvider rules="min:6" v-slot="{ errors }">
                                            <b-form-input type="password" v-model="usuario.password"></b-form-input>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col v-if="usuario.usuario_perfil == 1 && usuario.password.length > 0">
                                    <b-button :disabled="usuario.password.length == 0" @click="actualizar(0, 0, 0, 1, 0)" class="btn btn-success btn-block" title="Actualiza información de tu perfil">Actualizar mi perfil</b-button>
                                </b-col>
                                <b-col v-else>
                                    <b-button v-show="tipo_usuario_logeado < 4" :disabled="!valid || usuario.usuario_perfil == 1" @click="actualizar(1, 0, 0, 0, 0 ,0)" class="btn btn-success btn-block" title="Actualiza información de tu perfil">Actualizar mi perfil</b-button>
                                </b-col>
                            </b-row>
                        </b-tab>
                    </ValidationObserver>

                    <ValidationObserver ref="observer_usuario_academico" v-slot="{ valid }">
                        <b-tab title="Datos acádemicos">
                            <b-row v-show="usuario.tipo_persona == 1">
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="¿Posees algún título?">

                                            <b-form-radio-group id="radio-group-2" v-model="usuario.posee_titulo" name="radio-sub-component">
                                                <b-form-radio value="0">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No</b-form-radio>
                                                <b-form-radio value="1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sí</b-form-radio>
                                            </b-form-radio-group>
                                    </b-form-group>
                                </b-col>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group  label="¿Cuál es tu título?">
                                        <ValidationProvider :rules="usuario.tipo_persona == 1 && usuario.posee_titulo == 1 ? 'required|min:3|alpha_spaces' : ''" v-slot="{ errors }">
                                            <b-form-input type="text" v-model="usuario.titulo" :readonly="usuario.posee_titulo == 0"></b-form-input>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>


                            <b-row v-show="usuario.tipo_persona == 1 && usuario.posee_titulo == 1">
                                <b-col xs="12" sm="12" md="6" v-show="usuario.titulo.length > 0">
                                    <b-form-group label="¿Cuál fue tu casa de estudios?">
                                        <ValidationProvider :rules="usuario.titulo.length > 0 && usuario.tipo_persona == 1 && usuario.posee_titulo == 1 ? 'required|min:3' : ''" v-slot="{ errors }">
                                            <b-form-input type="text" v-model="usuario.casa_estudio" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row v-show="usuario.tipo_persona == 3">
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="¿Cuál es el título que obtendrás?">
                                        <ValidationProvider :rules="usuario.casa_estudio.length > 0 && usuario.tipo_persona == 3 ? 'required|min:3' : ''" v-slot="{ errors }">
                                            <b-form-input type="text" v-model="usuario.titulo" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col xs="12" sm="12" :md="usuario.titulo.length > 0 ? 6 : 12">
                                    <b-form-group v-show="usuario.titulo.length > 0"  label="¿Cuál es tu casa de estudios?">
                                        <ValidationProvider :rules="usuario.tipo_persona == 3 ? 'required|min:3|alpha_spaces' : ''" v-slot="{ errors }">
                                            <b-form-input type="text" v-model="usuario.casa_estudio" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row v-show="usuario.tipo_persona == 3">
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="¿Cuál es tu ramo favorito?">
                                        <ValidationProvider :rules="usuario.tipo_persona == 3 ? 'required|min:3' : ''" v-slot="{ errors }">
                                            <b-form-input type="text" v-model="usuario.ramo_favorito" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="¿Cuál es tu ramo menos favorito?">
                                        <ValidationProvider :rules="usuario.tipo_persona == 3 ? 'required|min:3' : ''" v-slot="{ errors }">
                                            <b-form-input type="text" v-model="usuario.ramo_odiado" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="¿Tienes algún oficio?" v-show="usuario.tipo_persona == 1">
                                        <ValidationProvider :rules="usuario.tipo_persona == 1 ? 'required|min:3' : ''" v-slot="{ errors }">
                                            <b-form-input type="text" v-model="usuario.ramo_favorito" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row v-if="usuario.tipo_persona == 3">
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group  label="¿En que fecha obtendrás tu certificado de título?">
                                        <ValidationProvider :rules="usuario.tipo_persona == 3 ? 'required|min:3' : ''" v-slot="{ errors }">
                                            <b-form-input type="date" v-model="usuario.fecha_titulo" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group  label="¿Necesitas ayuda para encontrar tu práctica profesional?">
                                        <ValidationProvider :rules="usuario.tipo_persona == 3 ? 'required' : ''" v-slot="{ errors }">
                                            <b-form-select v-model="usuario.seremi_o_practica" :disabled="tipo_usuario_logeado == 4">
                                                <option :value="null" selected>Seleccionar una opción</option>
                                                <option :value="1">¡Si por favor! </option>
                                                <option :value="2">¡No lo he considerado aún! </option>
                                                <option :value="3">No gracias</option>
                                            </b-form-select>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group  label="¿Qué tipos de softwares utilizas y cuál es tu nivel de experiencia?">
                                        <ValidationProvider rules="required|min:6|max:200" v-slot="{ errors }">
                                            <b-form-textarea v-model="usuario.software" placeholder="Escribe aquí ..." rows="3" max-rows="6" :readonly="tipo_usuario_logeado == 4"></b-form-textarea>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col>
                                    <b-button v-show="tipo_usuario_logeado < 4" :disabled="!valid || usuario.usuario_academico == 1" @click="actualizar(0, 1, 0, 0, 0 ,0)" class="btn btn-success btn-block" title="Actualizar datos">Actualizar datos académicos</b-button>
                                </b-col>
                            </b-row>
                        </b-tab>
                    </ValidationObserver>

                    <ValidationObserver ref="observer_usuario_ejercicio" v-slot="{ valid }">
                        <b-tab title="Datos del ejercicio">
                            <b-row>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="¿Tienes sitio web o una red social?">
                                        <ValidationProvider rules="required" v-slot="{ errors }">
                                            <b-form-select v-model="usuario.tiene_sitio" :disabled="tipo_usuario_logeado == 4">
                                                <option :value="0" selected>No</option>
                                                <option :value="1">Sí</option>
                                            </b-form-select>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="Pega aquí el link">
                                        <ValidationProvider rules="min:3" v-slot="{ errors }">
                                            <input type="text" v-model="usuario.sitio_web" class="form-control" :readonly="usuario.tiene_sitio == 0" :placeholder="usuario.tiene_sitio == 0 ? 'Ej: www.prevencionlebenco.cl' : ''"/>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group :label="usuario.tipo_persona == 1 ? '¿En qué rubro tienes mayor experiencia?' : '¿Cuál es el rubro que te llama la atención?'">
                                        <ValidationProvider rules="required" v-slot="{ errors }">
                                            <b-form-select v-model="usuario.profesion_id" :disabled="tipo_usuario_logeado == 4">
                                                <option :value="null" selected>Seleccionar una opción</option>
                                                <option v-for="(rubro, index) in rubros" :key="index" :value="rubro.id" v-text="rubro.nombre"></option>
                                            </b-form-select>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col xs="12" sm="12" md="6" v-show="usuario.tipo_persona == 1">
                                    <b-form-group label="¿Cuántos años lo ejerciste?">
                                        <ValidationProvider :rules="usuario.tipo_persona == 1 ? 'required|numeric|min_value:0' : ''" v-slot="{ errors }">
                                            <b-form-input type="number" v-model="usuario.tiempo_experiencia" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>


                            <b-form-group label="¿Cuál es tu preferencia en el ejercicio de la profesión u oficio?" >
                                <b-row>
                                    <b-col xs="12" sm="12" md="6">
                                        <ValidationProvider rules="required|numeric|min_value:0|max_value:100" v-slot="{ errors }">
                                            <label>Porcentaje en terreno: </label>
                                            <b-form-input type="number" v-model="usuario.porcentaje_terreno" placeholder="Porcentaje terreno" @keyup="calcularPorcentajeOficina()" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-col>
                                    <b-col xs="12" sm="12" md="6">
                                        <ValidationProvider rules="required|numeric|min:0" v-slot="{ errors }">
                                            <label>Porcentaje en oficina: </label>
                                            <b-form-input type="number" v-model="usuario.porcentaje_oficina" :readonly="true" placeholder="Porcentaje oficina"></b-form-input>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-col>
                                </b-row>
                            </b-form-group>

                            <b-row>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="¿Tienes algún curso de especialización?, ¿Quién lo dictó?">
                                        <ValidationProvider rules="required|min:6|max:200" v-slot="{ errors }">
                                            <b-form-textarea v-model="usuario.especializacion" placeholder="Escribe aquí ..." rows="3" max-rows="6" :readonly="tipo_usuario_logeado == 4"></b-form-textarea>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="Describe brevemente una habilidad sobresaliente">
                                        <ValidationProvider rules="required|min:6|max:200" v-slot="{ errors }">
                                            <b-form-textarea v-model="usuario.habilidad_sobresaliente" placeholder="Escribe aquí ..." rows="3" max-rows="6" :readonly="tipo_usuario_logeado == 4"></b-form-textarea>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="Describe brevemente una habilidad a mejorar">
                                       <ValidationProvider rules="required|min:6|max:200" v-slot="{ errors }">
                                            <b-form-textarea v-model="usuario.habilidad_mejora" placeholder="Escribe aquí ..." rows="3" max-rows="6" :readonly="tipo_usuario_logeado == 4"></b-form-textarea>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row v-show="usuario.tipo_persona == 1">
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="Describe brevemente tu mayor logro personal y profesional">
                                        <ValidationProvider :rules="usuario.tipo_persona == 1 ? 'required|min:3' : ''" v-slot="{ errors }">
                                            <b-form-input type="text" v-model="usuario.ultimo_trabajo" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="¿Cuál es el nombre de la Empresa donde obtuviste ese logro?">
                                        <ValidationProvider :rules="usuario.tipo_persona == 1 ? 'required|min:3' : ''" v-slot="{ errors }">
                                            <b-form-input type="text" v-model="usuario.ultimo_empresa" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row v-show="usuario.tipo_persona == 1">
                               <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="¿Cuál es el rubro principal de esa Empresa?">
                                        <ValidationProvider rules="required" v-slot="{ errors }">
                                            <b-form-select v-model="usuario.rubro_empresa" :disabled="tipo_usuario_logeado == 4">
                                                <option :value="null" selected>Seleccionar una opción</option>
                                                <option v-for="(rubro, index) in rubros" :key="index" :value="rubro.id" v-text="rubro.nombre"></option>
                                            </b-form-select>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="¿Cuál es el organismo administrador de esa Empresa?">
                                        <ValidationProvider :rules="usuario.tipo_persona == 1 ? 'required' : ''" v-slot="{ errors }">
                                            <b-form-select v-model="usuario.organismo_administrador_empresa" :disabled="tipo_usuario_logeado == 4">
                                                <option :value="null" selected>Seleccionar una opción</option>
                                                <option :value="2" selected>ACHS</option>
                                                <option :value="1" selected>Mutual</option>
                                                <option :value="3" selected>ISL</option>
                                                <option :value="4" selected>IST</option>
                                            </b-form-select>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col xs="12" sm="12" md="6" v-show="usuario.tipo_persona == 1">
                                    <b-form-group label="¿Cuál es tu situación laboral actual?">
                                        <ValidationProvider :rules="usuario.tipo_persona == 1 ? 'required' : ''" v-slot="{ errors }">
                                            <b-form-select v-model="usuario.situacion_actual" :disabled="tipo_usuario_logeado == 4">
                                                <option :value="null" selected>Seleccionar una opción</option>
                                                <option :value="1">Con trabajo fijo</option>
                                                <option :value="2">Con trabajo part-time</option>
                                                <option :value="3">Como asesor FreeLancer</option>
                                                <option :value="4">¡A la espera de una oportunidad!</option>

                                            </b-form-select>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="¿Cuál es tu preferencia laboral?">
                                        <ValidationProvider rules="required" v-slot="{ errors }">
                                            <b-form-select v-model="usuario.preferencia_laboral" :disabled="tipo_usuario_logeado == 4">
                                                <option :value="null">Seleccionar una opción</option>
                                                <option :value="1">Con trabajo fijo</option>
                                                <option :value="2">Con trabajo part-time</option>
                                                <option :value="3">Como asesor FreeLancer</option>
                                                <option :value="4">¡A la espera de una oportunidad!</option>
                                                <option :value="5">¡Quiero mi propia empresa!</option>

                                            </b-form-select>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>


                            <b-row>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="¿Tienes algún emprendimiento?">
                                        <ValidationProvider rules="required|min:3" v-slot="{ errors }">
                                            <b-form-textarea v-model="usuario.emprendimiento" placeholder="¿Si?, ¿no?, comenta brevemente ..." rows="3" max-rows="6" :readonly="tipo_usuario_logeado == 4"></b-form-textarea>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="¿Cómo se enteró del sitio web Prevención LebenCo.?">
                                        <ValidationProvider rules="required" v-slot="{ errors }">
                                            <b-form-select v-model="usuario.enterarse" :disabled="tipo_usuario_logeado == 4">
                                                <option :value="null" selected>Selecciona una opción</option>
                                                <option :value="1">Conversación</option>
                                                <option :value="2">Recomendación de un amigo </option>
                                                <option :value="3">Navegando en Google </option>
                                                <option :value="4">Publicidad</option>
                                                <option :value="5">Por medio del canal "Somos LebenCo." de YouTube </option>
                                                <option :value="6">otra ¿Cuál?</option>
                                            </b-form-select>

                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col xs="12" sm="12" md="6" v-show="usuario.enterarse == 6">
                                    <b-form-group :label="'¿Qué forma fue?'">
                                        <ValidationProvider :rules="usuario.enterarse == 5 ? 'required|min:3' : ''" v-slot="{ errors }">
                                            <b-form-input type="text" v-model="usuario.otra_forma" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row v-show="usuario.tipo_usuario == 1">
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group :label="labels.otro_rubro">
                                        <ValidationProvider :rules="usuario.tipo_usuario == 1 ? 'required|min:3' : ''" v-slot="{ errors }">
                                            <b-form-input type="text" v-model="usuario.otro_rubro" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="¿Le gustaría obtener coaching para desarrollar ideas y encontrar nuevas oportunidades?">
                                        <ValidationProvider rules="required" v-slot="{ errors }">
                                            <b-form-select v-model="usuario.coaching" :disabled="tipo_usuario_logeado == 4">
                                                <option :value="1">¡Claro!</option>
                                                <option :value="0" selected>No por ahora...</option>
                                            </b-form-select>

                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group :label="usuario.tipo_persona == 1 ? '¡Sube tu archivo Pdf con tu CV + Certificados + un proyecto (opcional), o lo que tú quieras para que te conozcamos!' : '¡Sube tu archivo Pdf con tu CV + Certificados + un proyecto (opcional), o lo que tú quieras para que te conozcamos!'">
                                        <b-form-file v-model="usuario.archivo_usuario" accept="application/pdf" placeholder="Sin archivo" drop-placeholder="Arrastra o suelta aquí" @input="actualizar_archivo_usuario"></b-form-file>
                                        <span class="mt-1" v-if="usuario.nombre_archivo != null">Archivo actual: {{ usuario.nombre_archivo }}</span>
                                    </b-form-group>
                                </b-col>
                            </b-row>


                            <b-row>
                                <b-col>
                                    <b-button v-show="tipo_usuario_logeado < 4" :disabled="!valid || usuario.usuario_ejercicio == 1" @click="actualizar(0, 0, 1, 0, 0 ,0)" class="btn btn-success btn-block" title="Actualiza información de tu perfil">Actualizar mi perfil</b-button>
                                </b-col>
                            </b-row>
                        </b-tab>
                    </ValidationObserver>

                    <b-tab title="Comentarios">
                        <b-form-group>
                            <b-container fluid>

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
                                    :items="items_pyme"
                                    :fields="fields_pyme"
                                    sticky-header>

                                    <template v-slot:cell(index)="data">
                                        {{ data.index + 1 }}
                                    </template>

                                    <template slot="empty">
                                        <center><h5>No hay registros para mostrar.</h5></center>
                                    </template>

                                    <template slot="emptyfiltered">
                                        <center><h5>No hay registros que coincidan con su solicitud.</h5></center>
                                    </template>

                                    <template v-slot:cell(tipo_votacion)="row">
                                        <label v-text="row.item.tipo_votacion == 1 ? 'Positivo' : 'Negativo'"></label>
                                    </template>
                                </b-table>
                            </b-container>
                        </b-form-group>
                    </b-tab>
                </b-tabs>

                <b-tabs v-else content-class="mt-3">
                    <ValidationObserver ref="observer_pyme_datos_comerciales" v-slot="{ valid }">
                        <b-tab title="Datos comerciales" active>
                            <b-form-group v-show="tipo_usuario_logeado < 3" label="Tipo de usuario">
                                <ValidationProvider rules="oneOf:1,2,3" v-slot="{ errors }">
                                    <b-form-select v-model="usuario.tipo_usuario">
                                        <option :value="0">Selecciona una opción</option>
                                        <option :value="1">Administrador</option>
                                        <option :value="2">Sub administrador</option>
                                        <option :value="3">Usuario normal</option>
                                    </b-form-select>
                                    <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                </ValidationProvider>
                            </b-form-group>
                            <b-row>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="Nombre de la razón social">
                                        <ValidationProvider rules="required|min:3" v-slot="{ errors }">
                                            <b-form-input type="text" v-model="usuario.nombre" :readonly="tipo_usuario_logeado >= 3"></b-form-input>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="RUT">
                                        <ValidationProvider rules="min:3" v-slot="{ errors }">
                                            <input type="text" v-rut v-model="usuario.run" class="form-control" :readonly="tipo_usuario_logeado >= 3" />
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="Nombre de fantasía">
                                        <ValidationProvider rules="required|min:1" v-slot="{ errors }">
                                            <b-form-input type="text" v-model="usuario.nombre_fantasia" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="Giro comercial principal">
                                        <ValidationProvider rules="required" v-slot="{ errors, validate }">
                                            <b-form-select v-model="usuario.giro_comercial" :disabled="tipo_usuario_logeado == 4" @change="validate">
                                                <option :value="null">Seleccionar una opción</option>
                                                <option v-for="(rubro, index) in rubros" :key="index" :value="rubro.id" v-text="rubro.nombre"></option>
                                            </b-form-select>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row v-show="tipo_usuario_logeado < 4">
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="N° telefónico">
                                        <ValidationProvider rules="required|numeric|digits:8" v-slot="{ errors }">
                                            <b-input-group prepend="+56 9">
                                                <b-form-input type="text" v-model="usuario.telefono" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            </b-input-group>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="Correo electrónico">
                                        <ValidationProvider rules="email" v-slot="{ errors }">
                                            <b-form-input type="email" v-model="usuario.email" :readonly="tipo_usuario_logeado > 2"></b-form-input>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="Dirección comercial actual">
                                        <ValidationProvider rules="required" v-slot="{ errors }">
                                            <b-form-input type="text" v-model="usuario.direccion" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="Comuna">
                                        <ValidationProvider rules="required" v-slot="{ errors }">
                                            <b-form-select v-model="usuario.comuna_id" :disabled="tipo_usuario_logeado == 4">
                                                <option :value="null" selected>Seleccionar una opción</option>
                                                <option v-for="(comuna, index) in comunas" :key="index" :value="comuna.id" v-text="comuna.nombre"></option>
                                            </b-form-select>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="Región">
                                        <ValidationProvider rules="required" v-slot="{ errors }">
                                            <b-form-select v-model="usuario.region">
                                                <option :value="null" selected>Seleccionar una opción</option>
                                                <option v-for="(region, index) in regiones" :key="index" :value="region.id" v-text="region.nombre"></option>
                                            </b-form-select>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="Cambiar contraseña (opcional)">
                                        <ValidationProvider rules="min:6" v-slot="{ errors }">
                                            <b-form-input type="password" v-model="usuario.password"></b-form-input>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col v-if="usuario.pyme_comercial == 1 && usuario.password.length > 0">
                                    <b-button :disabled="usuario.password.length == 0" @click="actualizar(0, 0, 0, 1, 0)" class="btn btn-success btn-block" title="Actualiza información de tu perfil">Actualizar mi perfil</b-button>
                                </b-col>
                                <b-col v-else>
                                    <b-button :disabled="!valid || usuario.pyme_comercial == 1" @click="actualizar(0, 0, 0, 1, 0)" class="btn btn-success btn-block" title="Actualiza información de tu perfil">Actualizar mi perfil</b-button>
                                </b-col>
                            </b-row>
                        </b-tab>
                    </ValidationObserver>

                    <ValidationObserver ref="observer_pyme_datos_pyme" v-slot="{ valid }">
                        <b-tab title="Datos de su pyme">
                            <b-row>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="¿Su Empresa es familiar?">
                                        <ValidationProvider rules="required" v-slot="{ errors }">
                                            <b-form-select v-model="usuario.empresa_familiar" :disabled="tipo_usuario_logeado == 4">
                                                <option :value="0" selected>No</option>
                                                <option :value="1" selected>Sí</option>
                                            </b-form-select>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="Años de funcionamiento">
                                        <ValidationProvider rules="required|numeric|min:0" v-slot="{ errors }">
                                            <input type="text" v-model="usuario.tiempo_funcionamiento" class="form-control" :readonly="tipo_usuario_logeado == 4" />
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="Meses en que considera una alta producción (temporada alta)">
                                        <ValidationProvider rules="required|min:5" v-slot="{ errors }">
                                            <input type="text" v-model="usuario.temporada_alta" class="form-control" placeholder="Ejemplo: Enero - marzo" :readonly="tipo_usuario_logeado == 4" />
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="N° de trabajadores contratados en temporada alta">
                                        <ValidationProvider rules="required|numeric|min:1" v-slot="{ errors }">
                                            <input type="text" v-model="usuario.cantidad_trabajadores" class="form-control" :readonly="tipo_usuario_logeado == 4" />
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="¿Cuál es el organismo administrador de su empresa?">
                                        <ValidationProvider rules="required" v-slot="{ errors, validate }">
                                            <b-form-select v-model="usuario.organismo_administrador_empresa" :disabled="tipo_usuario_logeado == 4" @change="validate">
                                                <option :value="null" selected>Seleccionar una opción</option>
                                                <option :value="2">ACHS</option>
                                                <option :value="1">Mutual</option>
                                                <option :value="3">ISL</option>
                                                <option :value="4">IST</option>
                                            </b-form-select>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group  label="Indique una cualidad sobresaliente de su negocio">
                                        <ValidationProvider rules="required|min:20|max:200" v-slot="{ errors }">
                                            <b-form-textarea v-model="usuario.descripcion_negocio" placeholder="Escribe aquí ..." rows="3" max-rows="6" :readonly="tipo_usuario_logeado == 4"></b-form-textarea>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group  label="Mencione su o sus servicios/productos más importantes">
                                        <ValidationProvider rules="required|min:20|max:200" v-slot="{ errors }">
                                            <b-form-textarea v-model="usuario.descripcion_servicio" placeholder="Escribe aquí ..." rows="3" max-rows="6" :readonly="tipo_usuario_logeado == 4"></b-form-textarea>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="¿Tienes sitio web o una red social?">
                                        <ValidationProvider rules="required" v-slot="{ errors }">
                                            <b-form-select v-model="usuario.tiene_sitio" :disabled="tipo_usuario_logeado == 4">
                                                <option :value="0" selected>No</option>
                                                <option :value="1">Sí</option>
                                            </b-form-select>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="Pega aquí el link">
                                        <ValidationProvider rules="min:3" v-slot="{ errors }">
                                            <input type="text" v-model="usuario.sitio_web" class="form-control" :readonly="usuario.tiene_sitio == 0" :placeholder="usuario.tiene_sitio == 0 ? 'Ej: www.prevencionlebenco.cl' : ''"/>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="¿Cómo se enteró del sitio web Prevención LebenCo.?">
                                        <ValidationProvider rules="required" v-slot="{ errors }">
                                            <b-form-select v-model="usuario.enterarse" :disabled="tipo_usuario_logeado == 4">
                                                <option :value="null" selected>Selecciona una opción</option>
                                                <option :value="1">Conversación</option>
                                                <option :value="2">Recomendación de un amigo </option>
                                                <option :value="3">Navegando en Google </option>
                                                <option :value="4">Publicidad</option>
                                                <option :value="5">Por medio del canal "Somos LebenCo." de YouTube </option>
                                                <option :value="6">otra ¿Cuál?</option>
                                            </b-form-select>

                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col xs="12" sm="12" md="6" v-show="usuario.enterarse == 6">
                                    <b-form-group :label="'¿De qué forma fue?'">
                                        <ValidationProvider :rules="usuario.enterarse == 5 ? 'required|min:3' : ''" v-slot="{ errors }">
                                            <b-form-input type="text" v-model="usuario.otra_forma" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="¿Le gustaría obtener coaching para desarrollar ideas, destacar sus productos o servicio y encontrar nuevas oportunidades?">
                                        <ValidationProvider rules="required" v-slot="{ errors }">
                                            <b-form-select v-model="usuario.coaching" :disabled="tipo_usuario_logeado == 4">
                                                <option :value="1">¡Claro!</option>
                                                <option :value="0" selected>No por ahora...</option>
                                            </b-form-select>

                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col xs="12" sm="12" md="6">
                                    <b-form-group label="Actualmente, ¿tiene algún otro emprendimiento?">
                                        <ValidationProvider rules="required|min:3" v-slot="{ errors }">
                                            <b-form-textarea v-model="usuario.emprendimiento" placeholder="¿Si?, ¿no?, comenta brevemente ..." rows="3" max-rows="6" :readonly="tipo_usuario_logeado == 4"></b-form-textarea>
                                            <span v-if="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0].replace('{field}', '') }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col>
                                    <b-button v-show="tipo_usuario_logeado < 4" :disabled="!valid || usuario.pyme_datos == 1" @click="actualizar(0, 0, 0, 0, 1)" class="btn btn-success btn-block" title="Actualiza información de tu perfil">Actualizar mi perfil</b-button>
                                </b-col>
                            </b-row>
                        </b-tab>
                    </ValidationObserver>

                    <b-tab title="Comentarios">
                        <b-form-group>
                            <b-container fluid>
                                <b-row>
                                    <b-col md="4" class="my-1">
                                        <b-form-group label-cols-sm="3" label="Filtrar" class="mb-0">
                                        <b-input-group>
                                            <b-form-input v-model="filter_pyme" placeholder="Escribe para buscar" />
                                            <b-input-group-append>
                                            <b-button :disabled="!filter_pyme" @click="filter_pyme = ''">Limpiar</b-button>
                                            </b-input-group-append>
                                        </b-input-group>
                                        </b-form-group>
                                    </b-col>

                                    <b-col md="4" class="my-1">
                                        <b-form-group label-cols-sm="3" label="Ordenar" class="mb-0">
                                        <b-input-group>
                                            <b-form-select v-model="sortBy_pyme" :options="sortOptions_pyme">
                                            <option slot="first" :value="null">-- nada --</option>
                                            </b-form-select>
                                            <b-form-select :disabled="!sortBy_pyme" v-model="sortDesc_pyme" slot="append">
                                            <option :value="false">Asc</option> <option :value="true">Desc</option>
                                            </b-form-select>
                                        </b-input-group>
                                        </b-form-group>
                                    </b-col>

                                    <b-col md="4" class="my-1">
                                        <b-form-group label-cols-sm="3" label="Dirección" class="mb-0">
                                        <b-input-group>
                                            <b-form-select v-model="sortDirection_pyme" slot="append">
                                            <option value="asc">Asc</option> <option value="desc">Desc</option>
                                            <option value="last">Último</option>
                                            </b-form-select>
                                        </b-input-group>
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
                                    :items="items_pyme"
                                    :fields="fields_pyme"
                                    sticky-header>


                                    <template v-slot:cell(index)="data">
                                        {{ data.index + 1 }}
                                    </template>

                                    <template slot="empty">
                                        <center><h5>No hay registros para mostrar.</h5></center>
                                    </template>

                                    <template slot="emptyfiltered">
                                        <center><h5>No hay registros que coincidan con su solicitud.</h5></center>
                                    </template>

                                    <template v-slot:cell(tipo_votacion)="row">
                                        <label v-text="row.item.tipo_votacion == 1 ? 'Positivo' : 'Negativo'"></label>
                                    </template>
                                </b-table>

                                <b-row>
                                    <b-col>
                                        <b-pagination :total-rows="totalRows_pyme" :per-page="perPage_pyme" v-model="currentPage_pyme" class="my-3" align="fill"/>
                                    </b-col>
                                </b-row>
                            </b-container>
                        </b-form-group>
                    </b-tab>

                </b-tabs>

            </b-card>
        </b-col>


    </b-row>
</template>

<script>
    export default {
        props: [
            'usuario_id', 'tipo_usuario_logeado', 'mensaje'
        ],
        data() {
            return {
                items_pyme: [],
                fields_pyme: [
                    { key: 'index', label: '#', sortable: true, sortDirection: 'desc', class: 'text-center' },
                    { key: 'nombre_usuario', label: 'Autor', sortable: true, class: 'text-left' },
                    { key: 'tipo_votacion', label: 'Tipo comentario', sortable: true, class: 'text-left' },
                    { key: 'descripcion', label: 'Comentario', sortable: true, class: 'text-left' }
                ],
                currentPage_pyme: 1,
                perPage_pyme: 10,
                totalRows_pyme: 0,
                pageOptions_pyme: [10, 25, 50, 100],
                sortBy_pyme: null,
                sortDesc_pyme: false,
                sortDirection_pyme: 'asc',
                filter_pyme: null,
                usuario: {
                    id: 0,
                    nombre: '',
                    nombre_fantasia: '',
                    giro_comercial: null,
                    run: '',
                    email: '',
                    password: '',
                    url_perfil: '',
                    tipo_usuario: 0,
                    tipo_persona: 0,
                    fecha_nacimiento: '',
                    telefono: null,
                    direccion: '',
                    comuna_id: null,
                    hijos: 0,
                    estado_civil: null,
                    casa_estudio: '',
                    ramo_favorito: '',
                    ramo_odiado: '',
                    titulo: '',
                    fecha_titulo: '',
                    seremi_o_practica: '',
                    software: '',
                    experiencia: '',
                    amigo: '',
                    profesion_id: null,
                    otro_rubro: '',
                    porcentaje_terreno: 0,
                    porcentaje_oficina: 0,
                    especializacion: '',
                    habilidad_sobresaliente: '',
                    habilidad_mejora: '',
                    preferencia_laboral: null,
                    emprendimiento: '',
                    enterarse: null,
                    coaching: 1,
                    tiempo_experiencia: 0,
                    ultimo_trabajo: '',
                    ultimo_empresa: '',
                    rubro_empresa: '',
                    organismo_administrador_empresa: null,
                    comunidad_pyme: false,
                    nombre_facturacion: '',
                    run_facturacion: '',
                    email_facturacion: '',
                    nombre_representante_facturacion: '',
                    telefono_facturacion: null,
                    empresa_familiar: 0,
                    tiempo_funcionamiento: null,
                    cantidad_trabajadores: null,
                    nombre_contratistas: '',
                    tiene_sitio: 0,
                    sitio_web: '',
                    usuario_perfil: 0,
                    usuario_academico: 0,
                    usuario_ejercicio: 0,
                    pyme_comercial: 0,
                    pyme_datos: 0,
                    pyme_facturacion: 0,
                    presiona_tabla_vip: 0,
                    radio_hijos: 0,
                    posee_titulo: 0,
                    temporada_alta: '',
                    descripcion_negocio: '',
                    descripcion_servicio: '',
                    region: null,
                    otra_forma: '',
                    fecha_valida: 0,
                    posicion: 0,
                    descripcion_administrador: '',
                    archivo_usuario: null,
                    nombre_archivo: null
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
                    organismo_administrador_empresa: '',
                    situacion_actual: null
                },
                comunas: [],
                regiones: [],
                profesiones: [],
                rubros: [],
                avatares: [],
                avatar_actual: 0
            }
        },
        computed: {
            valido(){
                return this.$refs.observer_usuario.validate()
            },
            sortOptions_pyme() {
                return this.fields_pyme.filter(f => f.sortable).map(f => {
                    return { text: f.label, value: f.key }
                })
            }
        },
        methods:{
            cambiar_avatar(accion){
                let me = this
                var total_avatares = this.avatares.length

                if(accion == 1){
                    me.avatar_actual == 0 ? me.avatar_actual = total_avatares : me.avatar_actual -= 1
                } else if(accion == 2){
                    me.avatar_actual == total_avatares ? me.avatar_actual = 0 : me.avatar_actual += 1
                }

                if(me.avatar_actual > 0){
                    me.usuario.url_perfil = me.avatares[me.avatar_actual - 1].url_imagen
                } else {
                    me.usuario.url_perfil = 'img/perfil.png'
                }
            },
            seleccionar_avatar(){
                Swal.fire({
                    title:  '¿Deseas cambiar tu avatar?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#8AB733',
                    cancelButtonColor: '#d7552a',
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                }).then((result) => {
                    if (result.value) {
                        let me = this;
                        axios.post('/usuario/actualizar/avatar',{
                            'id': me.usuario.id,
                            'url_imagen': me.usuario.url_perfil
                        }).then(function (response) {
                            me.listarUsuario();

                            $('#imagen_perfil_usuario').attr("src", 'storage/' + me.usuario.url_perfil);

                            me.avatar_actual = 0

                            Vue.$toast.open({
		                        message: 'Avatar cambiado exitosamente',
		                        type: 'success',
		                        duration: 5000
		                    });

                        }).catch(function (error) {
                            console.log(error);
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {}
                })


            },
            listar_avatares (){
                let me=this;
                axios.get('/avatares').then(function (response) {
                    me.avatares = response.data.avatares;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            onFiltered_pyme(filteredItems) {
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },
            listar_valoraciones(){
                let me=this;
                axios.get('/usuario/valoraciones/' + this.usuario.id).then(function (response) {
                    me.items_pyme = response.data.valoraciones;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            validar_fecha(){
                let me = this

                var f = new Date();
                var fecha = (f.getFullYear() - 18) + "-" + (f.getMonth() + 1) + "-" + f.getDate()

                if(me.usuario.fecha_nacimiento != null){
                    me.usuario.fecha_nacimiento < fecha ? me.usuario.fecha_valida = 0 : me.usuario.fecha_valida = 1
                } else {
                    me.usuario.fecha_valida = 0
                }
            },
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
            listarRubros (){
                let me=this;
                axios.get('/rubros/2').then(function (response) {
                    me.rubros = response.data.rubros;
                })
                .catch(function (error) {
                    console.log(error);
                });
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
            listarRegiones (){
                let me=this;
                axios.get('/regiones').then(function (response) {
                    me.regiones = response.data.regiones;
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
                    me.usuario.nombre_fantasia = response.data.usuario.nombre_fantasia;
                    me.usuario.giro_comercial = response.data.usuario.giro_comercial;
                    me.usuario.run = response.data.usuario.run;
                    me.usuario.email = response.data.usuario.email;
                    me.usuario.url_perfil = response.data.usuario.url_perfil == 'img/perfil.png' ?  response.data.usuario.url_perfil : 'storage/' + response.data.usuario.url_perfil;
                    me.usuario.tipo_usuario = response.data.usuario.tipo_usuario;
                    me.usuario.tipo_persona = response.data.usuario.tipo_persona;
                    me.usuario.fecha_nacimiento = response.data.usuario.fecha_nacimiento;
                    me.usuario.telefono = response.data.usuario.telefono;
                    me.usuario.direccion = response.data.usuario.direccion;
                    me.usuario.comuna_id = response.data.usuario.comuna_id;
                    me.usuario.hijos = response.data.usuario.hijos;
                    me.usuario.estado_civil = response.data.usuario.estado_civil;
                    me.usuario.casa_estudio = response.data.usuario.casa_estudio == null ? '' : response.data.usuario.casa_estudio;
                    me.usuario.ramo_favorito = response.data.usuario.ramo_favorito;
                    me.usuario.ramo_odiado = response.data.usuario.ramo_odiado;
                    me.usuario.titulo = response.data.usuario.titulo == null ? '' : response.data.usuario.titulo;
                    me.usuario.fecha_titulo = response.data.usuario.fecha_titulo;
                    me.usuario.seremi_o_practica = response.data.usuario.seremi_o_practica;
                    me.usuario.software = response.data.usuario.software;
                    me.usuario.experiencia = response.data.usuario.experiencia;
                    me.usuario.amigo = response.data.usuario.amigo;
                    me.usuario.profesion_id = response.data.usuario.profesion_id;
                    me.usuario.otro_rubro = response.data.usuario.otro_rubro;
                    me.usuario.porcentaje_terreno = response.data.usuario.porcentaje_terreno;
                    me.usuario.porcentaje_oficina = response.data.usuario.porcentaje_oficina;
                    me.usuario.especializacion = response.data.usuario.especializacion;
                    me.usuario.habilidad_sobresaliente = response.data.usuario.habilidad_sobresaliente;
                    me.usuario.habilidad_mejora = response.data.usuario.habilidad_mejora;
                    me.usuario.preferencia_laboral = response.data.usuario.preferencia_laboral;
                    me.usuario.emprendimiento = response.data.usuario.emprendimiento;
                    me.usuario.enterarse = response.data.usuario.enterarse;
                    me.usuario.coaching = response.data.usuario.coaching == null ? 1 : response.data.usuario.coaching;
                    me.usuario.tiempo_experiencia = response.data.usuario.tiempo_experiencia;
                    me.usuario.ultimo_trabajo = response.data.usuario.ultimo_trabajo;
                    me.usuario.ultimo_empresa = response.data.usuario.ultimo_empresa;
                    me.usuario.rubro_empresa = response.data.usuario.rubro_empresa;
                    me.usuario.organismo_administrador_empresa = response.data.usuario.organismo_administrador_empresa;
                    me.usuario.comunidad_pyme = response.data.usuario.comunidad_pyme == true ? 1 : 0;
                    me.usuario.top_five = response.data.usuario.top_five == true ? 1 : 0;
                    me.usuario.nombre_facturacion = response.data.usuario.nombre_facturacion
                    me.usuario.run_facturacion = response.data.usuario.run_facturacion
                    me.usuario.email_facturacion = response.data.usuario.email_facturacion
                    me.usuario.nombre_representante_facturacion = response.data.usuario.nombre_representante_facturacion
                    me.usuario.telefono_facturacion = response.data.usuario.telefono_facturacion
                    me.usuario.empresa_familiar = response.data.usuario.empresa_familiar
                    me.usuario.tiempo_funcionamiento = response.data.usuario.tiempo_funcionamiento
                    me.usuario.cantidad_trabajadores = response.data.usuario.cantidad_trabajadores
                    me.usuario.tiene_sitio = response.data.usuario.tiene_sitio
                    me.usuario.sitio_web = response.data.usuario.sitio_web
                    me.usuario.nombre_contratistas = response.data.usuario.nombre_contratistas
                    me.usuario.presiona_tabla_vip = response.data.usuario.presiona_tabla_vip

                    me.usuario.usuario_perfil = response.data.usuario.usuario_perfil
                    me.usuario.usuario_academico = response.data.usuario.usuario_academico
                    me.usuario.usuario_ejercicio = response.data.usuario.usuario_ejercicio
                    me.usuario.pyme_comercial = response.data.usuario.pyme_comercial
                    me.usuario.pyme_datos = response.data.usuario.pyme_datos
                    me.usuario.pyme_facturacion = response.data.usuario.pyme_facturacion
                    me.usuario.radio_hijos = response.data.usuario.hijos > 0 ? 1 : 0
                    me.usuario.posee_titulo = response.data.usuario.titulo == null ?  0 : 1

                    me.usuario.situacion_actual = response.data.usuario.situacion_actual
                    me.usuario.temporada_alta = response.data.usuario.temporada_alta
                    me.usuario.descripcion_negocio = response.data.usuario.descripcion_negocio
                    me.usuario.descripcion_servicio = response.data.usuario.descripcion_servicio
                    me.usuario.region = response.data.usuario.region
                    me.usuario.otra_forma = response.data.usuario.otra_forma
                    me.usuario.posicion = response.data.usuario.posicion
                    me.usuario.descripcion_administrador = response.data.usuario.descripcion_administrador
                    me.usuario.nombre_archivo = response.data.usuario.nombre_archivo_usuario


                    //Datos categoria
                    me.categoria.id = response.data.usuario.categoria.id;
                    me.categoria.nombre = response.data.usuario.categoria.nombre;
                    me.categoria.nivel = response.data.usuario.categoria.nivel;

                    me.mostrarLabels();
                    me.validar_fecha()
                    me.listar_valoraciones()
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
            actualizar_archivo_usuario(){
                let me = this

                if(me.usuario.archivo_usuario){
                    let formData = new FormData()
                    formData.append('usuario_id', me.usuario.id)
                    formData.append('archivo_usuario', me.usuario.archivo_usuario)

                    axios.post('usuario/crear/actualizar/archivo', formData).then(function (response) {
                        me.usuario.nombre_archivo = response.data.nombre_archivo_usuario

                        Vue.$toast.open({
                            message: 'Archivo actualizado exitosamente',
                            type: 'success',
                            duration: 5000
                        });

                    }).catch(function (error) {
                        console.error(error);
                    });
                }
            },
            actualizar(usuario_perfil, usuario_academico, usuario_ejercicio, pyme_comercial, pyme_datos){
                let me = this;

                axios.post('usuario/crear/actualizar',{
                    'usuario_id': me.usuario.id,
                    'nombre': me.usuario.nombre,
                    'nombre_fantasia': me.usuario.nombre_fantasia,
                    'giro_comercial': me.usuario.giro_comercial,
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
                    'comunidad_pyme': me.usuario.comunidad_pyme,
                    'top_five': me.usuario.top_five,
                    'nombre_facturacion': me.usuario.nombre_facturacion,
                    'run_facturacion': me.usuario.run_facturacion,
                    'email_facturacion': me.usuario.email_facturacion,
                    'nombre_representante_facturacion': me.usuario.nombre_representante_facturacion,
                    'telefono_facturacion': me.usuario.telefono_facturacion,
                    'empresa_familiar': me.usuario.empresa_familiar,
                    'tiempo_funcionamiento': me.usuario.tiempo_funcionamiento,
                    'cantidad_trabajadores': me.usuario.cantidad_trabajadores,
                    'tiene_sitio': me.usuario.tiene_sitio,
                    'sitio_web': me.usuario.sitio_web,
                    'nombre_contratistas': me.usuario.nombre_contratistas,
                    'usuario_perfil': usuario_perfil,
                    'usuario_academico': usuario_academico,
                    'usuario_ejercicio': usuario_ejercicio,
                    'pyme_comercial': pyme_comercial,
                    'pyme_datos': pyme_datos,
                    'situacion_actual': me.usuario.situacion_actual,
                    'temporada_alta': me.usuario.temporada_alta,
                    'descripcion_negocio': me.usuario.descripcion_negocio,
                    'descripcion_servicio': me.usuario.descripcion_servicio,
                    'otra_forma': me.usuario.otra_forma,
                    'descripcion_administrador': me.usuario.descripcion_administrador


                }).then(function (response) {
                    me.usuario.password = ''
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
            comunidad_pyme(accion){
                Swal.fire({
                    title: accion == 0 ? '¡Traquilo!, solo se verán tus datos comerciales en forma similar a quieres se encuentran activos, en la sección "Comunidad LebencCo"' : '¿Deseas salir de la tabla comunidad pyme?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#8AB733',
                    cancelButtonColor: '#d7552a',
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Rechazar',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                }).then((result) => {
                    if (result.value) {
                        let me = this;
                        axios.post('/usuario/tabla/comunidad',{
                            'accion': accion
                        }).then(function (response) {
                            me.listarUsuario();

                            Vue.$toast.open({
		                        message: accion == 0 ? 'Tus datos serán validados antes de acceder a la sección Comunidad LebenCo.' : 'Ya no estas en la tabla comunidad pyme',
		                        type: 'success',
		                        duration: 5000
		                    });

                        }).catch(function (error) {
                            console.log(error);
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {}
                })
            },
            tabla_vip(accion){
                Swal.fire({
                    title: accion == 0 ? '¿Deseas aparecer en la tabla vip?' : '¿Deseas salir de la tabla vip?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#8AB733',
                    cancelButtonColor: '#d7552a',
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Rechazar',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                }).then((result) => {
                    if (result.value) {
                        let me = this;
                        axios.post('/usuario/tabla/vip',{
                            'accion': accion
                        }).then(function (response) {
                            me.listarUsuario();

                            Vue.$toast.open({
		                        message: accion == 0 ? 'Pronto serás contactado por el Gerente de Prevención LebenCo.' : 'Ya no estas en la tabla vip',
		                        type: 'success',
		                        duration: 5000
		                    });

                        }).catch(function (error) {
                            console.log(error);
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {}
                })
            },
            calcularPorcentajeOficina(){
                this.usuario.porcentaje_oficina = 100 - this.usuario.porcentaje_terreno;
            }
        },
       mounted() {
            this.listarComunas();
            this.listarUsuario();
            this.listarProfesiones();
            this.listarRegiones();
            this.listarRubros();
            this.listar_avatares()
        }
    }
</script>

<style scoped>
    a:hover {
        color: #1E2F13;
    }

    .col-form-label{
        min-height: calc(1rem + 32px) !important;
    }

    .form-control {
        font-size: .875rem !important;
    }

    .btn-warning:hover {
        color: #212529 !important;
    }

    .table.b-table > thead > tr > .table-b-table-default, .table.b-table > tbody > tr > .table-b-table-default, .table.b-table > tfoot > tr > .table-b-table-default {
        color: none !important;
        background-color: none !important;
    }
</style>
