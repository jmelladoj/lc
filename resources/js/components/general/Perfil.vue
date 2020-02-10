<template>
    <b-row>
        <b-col cols="4">
            <b-card>
                <center class="mt-1">
                    <ValidationObserver ref="observer_foto_perfil">
                        <img v-bind:src="usuario.url_perfil" alt="Imagen de usuario" class="img-circle" width="150">

                        <b-row class="mt-3">
                            <b-col cols="6">
                                <ValidationProvider name="imagen" rules="required|image" v-slot="{ errors, validate }">
                                    <b-form-file v-show="tipo_usuario_logeado < 4" id="img_perfil" ref="file-input" name="img_perfil" accept="image/*" placeholder="Sin archivo" class="input-lg" @change="cambiarFoto(1)" @input="validate"></b-form-file>
                                    <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
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
                                <b-button v-if="tipo_usuario_logeado != 2" :disabled="usuario.usuario_perfil == 0 || usuario.usuario_academico == 0 || usuario.usuario_ejercicio == 0" size="md" variant="success" block @click="comunidad_pyme(usuario.comunidad_pyme)">
                                    ¡Quiero estar en comunidad pyme!
                                </b-button>
                                <b-button v-else :disabled="usuario.pyme_comercial == 0 || usuario.pyme_datos == 0 || usuario.pyme_facturacion == 0" size="md" variant="success" block @click="comunidad_pyme(usuario.comunidad_pyme)">
                                    ¡Quiero estar en comunidad pyme!
                                </b-button>
                            </b-col>
                            <b-col cols="12">
                                <b-button :disabled="usuario.presiona_tabla_vip  == 0" size="md" variant="warning" block @click="tabla_vip(usuario.top_five)">
                                    ¡Quiero estar en el top five!
                                </b-button>
                            </b-col>
                        </b-row>

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
                                <ValidationProvider name="tipo de usuario" rules="oneOf:1,2,3" v-slot="{ errors }">
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
                                        <ValidationProvider name="run / rut" rules="min:3" v-slot="{ errors }">
                                            <input type="text" v-rut v-model="usuario.run" class="form-control" :readonly="tipo_usuario_logeado >= 3" />
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row v-show="tipo_usuario_logeado < 4">
                                <b-col>
                                    <b-form-group label="Email">
                                        <ValidationProvider name="email" rules="email" v-slot="{ errors }">
                                            <b-form-input type="email" v-model="usuario.email" :readonly="tipo_usuario_logeado > 2"></b-form-input>
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
                                <b-col v-if="tipo_usuario_logeado == 3">
                                    <b-form-group label="Fecha de nacimiento">
                                        <ValidationProvider name="fecha de nacimiento" rules="required" v-slot="{ errors }">
                                            <b-form-input type="date" v-model="usuario.fecha_nacimiento" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group label="Teléfono">
                                        <ValidationProvider name="teléfono" rules="required|numeric|digits:8" v-slot="{ errors }">
                                            <b-input-group prepend="+56 9">
                                                <b-form-input type="number" v-model="usuario.telefono" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            </b-input-group>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col v-if="tipo_usuario_logeado > 2">
                                    <b-form-group label="Dirección">
                                        <ValidationProvider name="dirección" rules="required" v-slot="{ errors }">
                                            <b-form-input type="text" v-model="usuario.direccion" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col v-if="tipo_usuario_logeado > 2">
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
                            <b-row  v-if="tipo_usuario_logeado > 2">
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
                                        <b-row>
                                            <b-col>
                                                <b-form-radio-group id="radio-group-2" v-model="usuario.radio_hijos" name="radio-sub-component">
                                                    <b-form-radio value="0">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No</b-form-radio>
                                                    <b-form-radio value="1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sí</b-form-radio>
                                                </b-form-radio-group>
                                            </b-col>
                                            <b-col>
                                                <ValidationProvider name="hijos" rules="required|numeric|min:0" v-slot="{ errors }">
                                                    <b-form-input type="number" v-model="usuario.hijos" :readonly="tipo_usuario_logeado == 4" v-show="usuario.radio_hijos == 1"></b-form-input>
                                                    <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                                </ValidationProvider>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col>
                                    <b-button v-show="tipo_usuario_logeado < 4" :disabled="!valid" @click="actualizar(1, 0, 0, 0, 0 ,0)" class="btn btn-success btn-block" title="Actualiza información de tu perfil">Actualizar mi perfil</b-button>
                                </b-col>
                            </b-row>
                        </b-tab>
                    </ValidationObserver>

                    <ValidationObserver ref="observer_usuario_academico" v-slot="{ valid }">
                        <b-tab title="Datos acádemicos">
                            <b-row>
                                <b-col>
                                    <b-form-group :label="usuario.tipo_persona == 1 ? '¿Cuál fue tu casa de estudios?' : '¿Cuál es tu casa de estudios?'">
                                        <ValidationProvider name="casa de estudio" rules="required|min:3|alpha_spaces" v-slot="{ errors }">
                                            <b-form-input type="text" v-model="usuario.casa_estudio" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group :label="usuario.tipo_persona == 1 ? '¿Cuál fue tu ramo favorito?' : '¿Cuál es tu ramo favorito?'">
                                        <ValidationProvider name="ramo favorito" rules="required|min:3" v-slot="{ errors }">
                                            <b-form-input type="text" v-model="usuario.ramo_favorito" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col>
                                    <b-form-group  :label="usuario.tipo_persona == 1 ? '¿Cuál fue tu ramo menos favorito?' : '¿Cuál es tu ramo favorito?'">
                                        <ValidationProvider name="ramo menos favorito" rules="required|min:3" v-slot="{ errors }">
                                            <b-form-input type="text" v-model="usuario.ramo_odiado" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group  :label="usuario.tipo_persona == 1 ? '¿Cuál es tu título?' : '¿Cuál es el título que obtendrás?'">
                                        <ValidationProvider name="título" rules="required|min:3" v-slot="{ errors }">
                                            <b-form-input type="text" v-model="usuario.titulo" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row v-if="usuario.tipo_persona == 3">
                                <b-col>
                                    <b-form-group  label="¿En que fecha obtendrás tu certificado de título?">
                                        <ValidationProvider name="fecha de título" :rules="usuario.tipo_persona == 3 ? 'required|min:3' : ''" v-slot="{ errors }">
                                            <b-form-input type="date" v-model="usuario.fecha_titulo" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row v-if="usuario.tipo_persona == 3">
                                <b-col>
                                    <b-form-group  label="¿Dónde realizarás tu práctica profesional?">
                                        <ValidationProvider name="práctica profesional" :rules="usuario.tipo_persona == 3 ? 'required|min:5|max:200' : ''" v-slot="{ errors }">
                                            <b-form-textarea v-model="usuario.seremi_o_practica" placeholder="Escribe aquí ..." rows="3" max-rows="6" :readonly="tipo_usuario_logeado == 4"></b-form-textarea>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col>
                                    <b-form-group  label="¿Qué tipos de softwares utilizas y cuál es tu nivel de experiencia con ellos?">
                                        <ValidationProvider name="detalle de software" rules="required|min:20|max:200" v-slot="{ errors }">
                                            <b-form-textarea v-model="usuario.software" placeholder="Escribe aquí ..." rows="3" max-rows="6" :readonly="tipo_usuario_logeado == 4"></b-form-textarea>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col>
                                    <b-button v-show="tipo_usuario_logeado < 4" :disabled="!valid" @click="actualizar(0, 1, 0, 0, 0 ,0)" class="btn btn-success btn-block" title="Actualizar datos">Actualizar datos académicos</b-button>
                                </b-col>
                            </b-row>
                        </b-tab>
                    </ValidationObserver>

                    <ValidationObserver ref="observer_usuario_ejercicio" v-slot="{ valid }">
                        <b-tab title="Datos del ejercicio">
                            <b-row v-show="usuario.tipo_persona == 1">
                                <b-col>
                                    <b-form-group label="¿Tienes sitio web o una red social?">
                                        <ValidationProvider name="sitio web" :rules="usuario.tipo_persona == 1 ? 'required|oneOf:0,1' : ''" v-slot="{ errors }">
                                            <b-form-select v-model="usuario.tiene_sitio" :disabled="tipo_usuario_logeado == 4">
                                                <option :value="0" selected>No</option>
                                                <option :value="1">Sí</option>
                                            </b-form-select>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group label="Pega aquí el link">
                                        <ValidationProvider name="Link" :rules="usuario.tipo_persona == 1 ? 'min:3' : ''" v-slot="{ errors }">
                                            <input type="text" v-model="usuario.sitio_web" class="form-control" :readonly="usuario.tiene_sitio == 0"/>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col>
                                    <b-form-group :label="usuario.tipo_persona == 1 ? '¿Cuál es tu rubro con mayor experiencia?' : '¿Cuál es el rubro que te llama la atención?'">
                                        <ValidationProvider name="rubro" rules="required" v-slot="{ errors }">
                                            <b-form-select v-model="usuario.profesion_id" :disabled="tipo_usuario_logeado == 4">
                                                <option :value="0" selected>Seleccionar una opción</option>
                                                <option v-for="(profesion, index) in profesiones.filter(p => p.tipo_persona == usuario.tipo_persona)" :key="index" :value="profesion.id" v-text="profesion.nombre"></option>
                                            </b-form-select>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col v-show="usuario.tipo_persona == 1">
                                    <b-form-group label="En total, ¿cuántos años haz ejercido">
                                        <ValidationProvider name="experiencia" :rules="usuario.tipo_persona == 1 ? 'required|numeric|min_value:0' : ''" v-slot="{ errors }">
                                            <b-form-input type="number" v-model="usuario.tiempo_experiencia" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>


                            <b-form-group label="¿Cuál es tu preferencia en el ejercicio de la profesión?">
                                <b-row>
                                    <b-col>
                                        <ValidationProvider name="porcentaje terreno" rules="required|numeric|min_value:0|max_value:100" v-slot="{ errors }">
                                            <label>Porcentaje de terreno: </label>
                                            <b-form-input type="number" v-model="usuario.porcentaje_terreno" placeholder="Porcentaje terreno" @keyup="calcularPorcentajeOficina()" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-col>
                                    <b-col>
                                        <ValidationProvider name="porcentaje oficina" rules="required|numeric|min:0" v-slot="{ errors }">
                                            <label>Porcentaje de oficina: </label>
                                            <b-form-input type="number" v-model="usuario.porcentaje_oficina" :readonly="true" placeholder="Porcentaje oficina"></b-form-input>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-col>
                                </b-row>
                            </b-form-group>

                            <b-row>
                                <b-col>
                                    <b-form-group label="¿Tienes algún curso de especialización?">
                                        <ValidationProvider name="especialización" rules="required|min:20|max:200" v-slot="{ errors }">
                                            <b-form-textarea v-model="usuario.especializacion" placeholder="Escribe aquí ..." rows="3" max-rows="6" :readonly="tipo_usuario_logeado == 4"></b-form-textarea>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col>
                                    <b-form-group label="Describe brevemente una habilidad sobresaliente">
                                        <ValidationProvider name="habilidad sobresaliente" rules="required|min:20|max:200" v-slot="{ errors }">
                                            <b-form-textarea v-model="usuario.habilidad_sobresaliente" placeholder="Escribe aquí ..." rows="3" max-rows="6" :readonly="tipo_usuario_logeado == 4"></b-form-textarea>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group label="Describe brevemente una habilidad a mejorar">
                                       <ValidationProvider name="habilidad a mejorar" rules="required|min:20|max:200" v-slot="{ errors }">
                                            <b-form-textarea v-model="usuario.habilidad_mejora" placeholder="Escribe aquí ..." rows="3" max-rows="6" :readonly="tipo_usuario_logeado == 4"></b-form-textarea>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row v-show="usuario.tipo_persona == 1">
                                <b-col>
                                    <b-form-group label="Describe brevemente el mayor logro personal/profesional obtenido en tu último cargo.">
                                        <ValidationProvider name="mayor logro" :rules="usuario.tipo_persona == 1 ? 'required|min:3' : ''" v-slot="{ errors }">
                                            <b-form-input type="text" v-model="usuario.ultimo_trabajo" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group label="¿cuál es el nombre de tu actual empresa o la última donde trabajaste?">
                                        <ValidationProvider name="empresa" :rules="usuario.tipo_persona == 1 ? 'required|min:3' : ''" v-slot="{ errors }">
                                            <b-form-input type="text" v-model="usuario.ultimo_empresa" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row v-show="usuario.tipo_persona == 1">
                                <b-col>
                                    <b-form-group label="¿cuál es el rubro principal de esa Empresa?">
                                        <ValidationProvider name="trabajo" :rules="usuario.tipo_persona == 1 ? 'required|min:3' : ''" v-slot="{ errors }">
                                            <b-form-input type="text" v-model="usuario.rubro_empresa" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group label="¿Cuál es el organismo administrador de esa empresa?">
                                        <ValidationProvider name="preferencia laboral" :rules="usuario.tipo_persona == 1 ? 'required' : ''" v-slot="{ errors }">
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
                                <b-col v-show="usuario.tipo_persona == 1">
                                    <b-form-group label="¿Cuál es tu situación laboral actual?">
                                        <ValidationProvider name="situación laboral" :rules="usuario.tipo_persona == 1 ? 'required' : ''" v-slot="{ errors }">
                                            <b-form-select v-model="usuario.situacion_actual" :disabled="tipo_usuario_logeado == 4">
                                                <option :value="0" selected>Seleccionar una opción</option>
                                                <option :value="1">Con trabajo fijo</option>
                                                <option :value="2">Con trabajo part-time</option>
                                                <option :value="3">Como asesor FreeLancer</option>
                                                <option :value="4">¡A la espera de una oportunidad!</option>

                                            </b-form-select>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group label="¿Cuál es tu preferencia laboral?">
                                        <ValidationProvider name="preferencia laboral" rules="required" v-slot="{ errors }">
                                            <b-form-select v-model="usuario.preferencia_laboral" :disabled="tipo_usuario_logeado == 4">
                                                <option :value="0">Seleccionar una opción</option>
                                                <option :value="1">Con trabajo fijo</option>
                                                <option :value="2">Con trabajo part-time</option>
                                                <option :value="3">Como asesor FreeLancer</option>
                                                <option :value="4">¡A la espera de una oportunidad!</option>
                                                <option :value="5">¡Quiero mi propia empresa!</option>

                                            </b-form-select>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>


                            <b-row>
                                <b-col>
                                    <b-form-group label="¿Tienes algún emprendimiento?">
                                        <ValidationProvider name="emprendimiento" rules="required|min:3" v-slot="{ errors }">
                                            <b-form-textarea v-model="usuario.emprendimiento" placeholder="¿Si?, ¿no?, comenta brevemente ..." rows="3" max-rows="6" :readonly="tipo_usuario_logeado == 4"></b-form-textarea>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col>
                                    <b-form-group label="¿Cómo se enteró del sitio web Prevención LebenCo.?">
                                        <ValidationProvider name="enterarse" rules="required" v-slot="{ errors }">
                                            <b-form-select v-model="usuario.enterarse" :disabled="tipo_usuario_logeado == 4">
                                                <option :value="0" selected>Conversación</option>
                                                <option :value="1">Recomendación de un amigo </option>
                                                <option :value="2">Navegando en Google </option>
                                                <option :value="3">Publicidad</option>
                                                <option :value="4">Por medio del canal "Somos Pyme" de YouTube </option>
                                                <option :value="5">otra ¿Cuál?</option>
                                            </b-form-select>

                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group label="¿Le gustaría obtener coaching para desarrollar su potencial y diferenciarse del resto de los colegas?">
                                        <ValidationProvider name="coaching" rules="required" v-slot="{ errors }">
                                            <b-form-select v-model="usuario.coaching" :disabled="tipo_usuario_logeado == 4">
                                                <option :value="0" selected>No por ahora...</option>
                                                <option :value="1">Claro</option>
                                            </b-form-select>

                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row v-show="usuario.tipo_usuario == 1">
                                <b-col>
                                    <b-form-group :label="labels.otro_rubro">
                                        <ValidationProvider name="otro rubro" :rules="usuario.tipo_usuario == 1 ? 'required|min:3' : ''" v-slot="{ errors }">
                                            <b-form-input type="text" v-model="usuario.otro_rubro" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col>
                                    <b-form-group :label="usuario.tipo_persona == 1 ? 'Debe subir a su cuenta un archivo Pdf que contenga: El certificado de título, el registro de experto en prevención otorgado por Seremi de salud y su cédula de identidad por ambos lados. El cual se mantendrá en su misma cuenta para que LebenCo. descargue este archivo, incluyendo el listado de preguntas y respuestas del perfil.' : 'Debe subir a su cuenta un archivo Pdf que contenga: El certificado de alumno regular u otro registro que acredite que es estudiante y su cédula de identidad por ambos lados. El cual se mantendrá en su misma cuenta para que LebenCo. descargue este archivo, incluyendo el listado de preguntas y respuestas del perfil.'">
                                        <b-form-file  ref="file-input" accept="application/pdf" placeholder="Sin archivo" ></b-form-file>
                                    </b-form-group>
                                </b-col>
                            </b-row>


                            <b-row>
                                <b-col>
                                    <b-button v-show="tipo_usuario_logeado < 4" :disabled="!valid" @click="actualizar(0, 0, 1, 0, 0 ,0)" class="btn btn-success btn-block" title="Actualiza información de tu perfil">Actualizar mi perfil</b-button>
                                </b-col>
                            </b-row>
                        </b-tab>
                    </ValidationObserver>
                </b-tabs>

                <b-tabs v-else content-class="mt-3">
                    <ValidationObserver ref="observer_pyme_datos_comerciales" v-slot="{ valid }">
                        <b-tab title="Datos comerciales" active>
                            <b-form-group v-show="tipo_usuario_logeado < 3" label="Tipo de usuario">
                                <ValidationProvider name="tipo de usuario" rules="oneOf:1,2,3" v-slot="{ errors }">
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
                                    <b-form-group label="Nombre de la razón social completa">
                                        <ValidationProvider name="nombre" rules="required|min:3|alpha_spaces" v-slot="{ errors }">
                                            <b-form-input type="text" v-model="usuario.nombre" :readonly="tipo_usuario_logeado >= 3"></b-form-input>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group label="Rut">
                                        <ValidationProvider name="run / rut" rules="min:3" v-slot="{ errors }">
                                            <input type="text" v-rut v-model="usuario.run" class="form-control" :readonly="tipo_usuario_logeado >= 3" />
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col>
                                    <b-form-group label="Nombre de fantasía">
                                        <ValidationProvider name="nombre de fantasía" rules="required|min:1" v-slot="{ errors }">
                                            <b-form-input type="text" v-model="usuario.nombre_fantasia" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group label="Giro comercial">
                                        <ValidationProvider name="giro comercial" rules="min:3" v-slot="{ errors }">
                                            <input type="text" v-model="usuario.giro_comercial" class="form-control" :readonly="tipo_usuario_logeado == 4" />
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row v-show="tipo_usuario_logeado < 4">
                                <b-col>
                                    <b-form-group label="Email">
                                        <ValidationProvider name="email" rules="email" v-slot="{ errors }">
                                            <b-form-input type="email" v-model="usuario.email" :readonly="tipo_usuario_logeado > 2"></b-form-input>
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
                                <b-col v-if="tipo_usuario_logeado > 2">
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
                                <b-col v-if="tipo_usuario_logeado > 2">
                                    <b-form-group label="Dirección comercial actual">
                                        <ValidationProvider name="dirección" rules="required" v-slot="{ errors }">
                                            <b-form-input type="text" v-model="usuario.direccion" :readonly="tipo_usuario_logeado == 4"></b-form-input>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col>
                                    <b-button v-show="tipo_usuario_logeado < 4" :disabled="!valid" @click="actualizar(0, 0, 0, 1, 0 ,0)" class="btn btn-success btn-block" title="Actualiza información de tu perfil">Actualizar mi perfil</b-button>
                                </b-col>
                            </b-row>
                        </b-tab>
                    </ValidationObserver>

                    <ValidationObserver ref="observer_pyme_datos_pyme" v-slot="{ valid }">
                        <b-tab title="Datos de su pyme">
                            <!--<b-row>
                                <b-col>
                                    <b-form-group label="¿Tienes sitio web?">
                                        <ValidationProvider name="empresa familiar" rules="required|oneOf:0,1" v-slot="{ errors }">
                                            <b-form-select v-model="usuario.tiene_sitio" :disabled="tipo_usuario_logeado == 4">
                                                <option :value="0" selected>No</option>
                                                <option :value="1">Sí</option>
                                            </b-form-select>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                <b-form-group label="Link">
                                        <ValidationProvider name="Link" rules="min:3" v-slot="{ errors }">
                                            <input type="text" v-model="usuario.sitio_web" class="form-control"/>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>-->
                            <b-row>
                                <b-col>
                                    <b-form-group label="¿Es empresa familiar?">
                                        <ValidationProvider name="empresa familiar" rules="required|oneOf:0,1" v-slot="{ errors }">
                                            <b-form-select v-model="usuario.empresa_familiar" :disabled="tipo_usuario_logeado == 4">
                                                <option :value="0" selected>No</option>
                                                <option :value="1" selected>Sí</option>
                                            </b-form-select>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group label="Años de funcionamiento">
                                        <ValidationProvider name="años de funcionamiento" rules="required|numeric|min:0" v-slot="{ errors }">
                                            <input type="text" v-model="usuario.tiempo_funcionamiento" class="form-control" :readonly="tipo_usuario_logeado == 4" />
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col>
                                    <b-form-group label="Meses en que considera una alta producción (temporada alta)">
                                        <ValidationProvider name="temporada alta" rules="required|min:5" v-slot="{ errors }">
                                            <input type="text" v-model="usuario.temporada_alta" class="form-control" placeholder="Ejemplo: Enero - marzo" :readonly="tipo_usuario_logeado == 4" />
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group label="N° de trabajadores contratados en temporada alta">
                                        <ValidationProvider name="número de trabajadores" rules="required|numeric|min:1" v-slot="{ errors }">
                                            <input type="text" v-model="usuario.cantidad_trabajadores" class="form-control" :readonly="tipo_usuario_logeado == 4" />
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col>
                                    <b-form-group label="¿Cuál es el organismo administrador de esa empresa?">
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
                                    <b-form-group  label="Breve una descripción que le permita llamar la atención hacia su negocio">
                                        <ValidationProvider name="descripción del negocio" rules="required|min:20|max:200" v-slot="{ errors }">
                                            <b-form-textarea v-model="usuario.descripcion_negocio" placeholder="Escribe aquí ..." rows="3" max-rows="6" :readonly="tipo_usuario_logeado == 4"></b-form-textarea>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group  label="Breve descripción de su servicio o productos que lo representan">
                                        <ValidationProvider name="descripción del servicio" rules="required|min:20|max:200" v-slot="{ errors }">
                                            <b-form-textarea v-model="usuario.descripcion_servicio" placeholder="Escribe aquí ..." rows="3" max-rows="6" :readonly="tipo_usuario_logeado == 4"></b-form-textarea>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col>
                                    <b-form-group label="¿Tienes sitio web o una red social?">
                                        <ValidationProvider name="sitio web" rules="required|oneOf:0,1" v-slot="{ errors }">
                                            <b-form-select v-model="usuario.tiene_sitio" :disabled="tipo_usuario_logeado == 4">
                                                <option :value="0" selected>No</option>
                                                <option :value="1">Sí</option>
                                            </b-form-select>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group label="Pega aquí el link">
                                        <ValidationProvider name="Link" rules="min:3" v-slot="{ errors }">
                                            <input type="text" v-model="usuario.sitio_web" class="form-control" :readonly="usuario.tiene_sitio == 0"/>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col>
                                    <b-form-group label="¿Cómo se enteró del sitio web Prevención LebenCo.?">
                                        <ValidationProvider name="enterarse" rules="required" v-slot="{ errors }">
                                            <b-form-select v-model="usuario.enterarse" :disabled="tipo_usuario_logeado == 4">
                                                <option :value="0" selected>Conversación</option>
                                                <option :value="1">Recomendación de un amigo </option>
                                                <option :value="2">Navegando en Google </option>
                                                <option :value="3">Publicidad</option>
                                                <option :value="4">Por medio del canal "Somos Pyme" de YouTube </option>
                                                <option :value="5">otra ¿Cuál?</option>
                                            </b-form-select>

                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group label="¿Le gustaría obtener nuevos puntos de vista para potenciar sus ideas, destacar sus productos o servicio y hacer crecer su negocio?">
                                        <ValidationProvider name="puntos de vista" rules="required" v-slot="{ errors }">
                                            <b-form-select v-model="usuario.coaching" :disabled="tipo_usuario_logeado == 4">
                                                <option :value="0" selected>No por ahora...</option>
                                                <option :value="1">Claro</option>
                                            </b-form-select>

                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col>
                                    <b-form-group label="¿Tienes algún emprendimiento?">
                                        <ValidationProvider name="emprendimiento" rules="required|min:3" v-slot="{ errors }">
                                            <b-form-textarea v-model="usuario.emprendimiento" placeholder="¿Si?, ¿no?, comenta brevemente ..." rows="3" max-rows="6" :readonly="tipo_usuario_logeado == 4"></b-form-textarea>
                                            <span v-show="errors[0]"><span class="d-block alert alert-danger m-t-5">{{ errors[0] }}</span></span>
                                        </ValidationProvider>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col>
                                    <b-button v-show="tipo_usuario_logeado < 4" :disabled="!valid" @click="actualizar(0, 0, 0, 0, 1 ,0)" class="btn btn-success btn-block" title="Actualiza información de tu perfil">Actualizar mi perfil</b-button>
                                </b-col>
                            </b-row>
                        </b-tab>
                    </ValidationObserver>

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
                usuario: {
                    id: 0,
                    nombre: '',
                    nombre_fantasia: '',
                    giro_comercial: '',
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
                    enterarse: 0,
                    coaching: 0,
                    tiempo_experiencia: 0,
                    ultimo_trabajo: '',
                    ultimo_empresa: '',
                    rubro_empresa: '',
                    organismo_administrador_empresa: 0,
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
                    temporada_alta: '',
                    descripcion_negocio: '',
                    descripcion_servicio: ''
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
                    situacion_actual: 0
                },
                comunas: [],
                profesiones: []
            }
        },
        computed: {
            valido(){
                return this.$refs.observer_usuario.validate()
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
                    me.usuario.nombre_fantasia = response.data.usuario.nombre_fantasia;
                    me.usuario.giro_comercial = response.data.usuario.giro_comercial;
                    me.usuario.run = response.data.usuario.run;
                    me.usuario.email = response.data.usuario.email;
                    me.usuario.url_perfil = response.data.usuario.url_perfil == 'img/perfil.svg' ?  response.data.usuario.url_perfil : 'storage/' + response.data.usuario.url_perfil;
                    me.usuario.tipo_usuario = response.data.usuario.tipo_usuario;
                    me.usuario.tipo_persona = response.data.usuario.tipo_persona;
                    me.usuario.fecha_nacimiento = response.data.usuario.fecha_nacimiento;
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
                    me.usuario.profesion_id = response.data.usuario.profesion_id == null ? null : response.data.usuario.profesion_id;
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

                    me.usuario.situacion_actual = response.data.usuario.situacion_actual
                    me.usuario.temporada_alta = response.data.usuario.temporada_alta
                    me.usuario.descripcion_negocio = response.data.usuario.descripcion_negocio
                    me.usuario.descripcion_servicio = response.data.usuario.descripcion_servicio



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
            actualizar(usuario_perfil, usuario_academico, usuario_ejercicio, pyme_comercial, pyme_datos, pyme_facturacion){
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
                    'pyme_facturacion': pyme_facturacion,
                    'situacion_actual': me.usuario.situacion_actual,
                    'temporada_alta': me.usuario.temporada_alta,
                    'descripcion_negocio': me.usuario.descripcion_negocio,
                    'descripcion_servicio': me.usuario.descripcion_servicio


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
            comunidad_pyme(accion){
                Swal.fire({
                    title: accion == 0 ? '¿Deseas aparecer en la tabla comunidad pyme?' : '¿Deseas salir de la tabla comunidad pyme?',
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
                        axios.post('/usuario/tabla/comunidad',{
                            'accion': accion
                        }).then(function (response) {
                            me.listarUsuario();

                            Vue.$toast.open({
		                        message: accion == 0 ? 'Ya estas en la tabla comunidad pyme!' : 'Ya no estas en la tabla comunidad pyme',
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
                    confirmButtonText: 'Aceptar!',
                    cancelButtonText: 'Cancelar',
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
		                        message: accion == 0 ? 'Hemos procesado tu solicitud, pronto te contactaremos' : 'Ya no estas en la tabla vip',
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
</style>
