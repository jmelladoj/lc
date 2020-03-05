<aside class="left-sidebar">
    <div class="scroll-sidebar">
        @include('general.FotoPerfil')

        <nav class="sidebar-nav">
            <ul id="sidebarnav" v-show="ubicacion == 0">
                <li class="nav-small-cap">--- Menú</li>
                <li>
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i><span class="hide-menu">General </span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li @click="menu=0"><a href="javascript:void(0)">LebenCo.</a></li>
                        <li @click="menu=7"><a href="javascript:void(0)">Pymes</a></li>
                        <li @click="menu=6"><a href="javascript:void(0)">Organismos</a></li>
                    </ul>
                </li>

                <li>
                    <a @click="menu=1" class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-picture-o" aria-hidden="true"></i><span class="hide-menu">Sliders </span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li @click="menu=1"><a href="javascript:void(0)">General</a></li>
                        <li @click="menu=8"><a href="javascript:void(0)">Comunidad</a></li>
                    </ul>
                </li>

                <li>
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-folder-o" aria-hidden="true"></i><span class="hide-menu">Páginas </span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li @click="menu=3"><a href="javascript:void(0)">Comunidad LebenCo</a></li>
                        <li @click="menu=2"><a href="javascript:void(0)">Nosotros</a></li>
                        <li @click="menu=4"><a href="javascript:void(0)">Servicios</a></li>
                        <li @click="menu=5"><a href="javascript:void(0)">Login</a></li>
                        <li @click="menu=7"><a href="javascript:void(0)">Bienvenida</a></li>
                    </ul>
                </li>

                <li>
                    <a @click="menu=9" class="waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-image" aria-hidden="true"></i><span class="hide-menu">Avatares </span></a>
                </li>


            </ul>

            <ul id="sidebarnav" v-if="ubicacion == 1 && menu_administrador == 0">
                <li class="nav-small-cap">--- ¿Ver cómo?</li>

                <li v-if="menu_administrador==0">
                    <a @click="menu_administrador=1" class="waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i><span class="hide-menu">Usuario </span></a>
                </li>
                <li v-if="menu_administrador==1">
                    <a @click="menu_administrador=0" class="waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i><span class="hide-menu">Administrador </span></a>
                </li>

                <li class="nav-small-cap">--- Menú</li>
                <li>
                    <a class="has-arrow waves-effect waves-dark" @click="menu=1" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-folder-o" aria-hidden="true"></i><span class="hide-menu">Contenido </span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li @click="menu=0"><a href="javascript:void(0)">Categorías</a></li>
                        <boton-documentos-aprobados></boton-documentos-aprobados>
                        <boton-documentos-pendientes></boton-documentos-pendientes>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow waves-effect waves-dark" @click="menu=5" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-users" aria-hidden="true"></i><span class="hide-menu">Clientes </span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li @click="menu=5"><a href="javascript:void(0)">Usuarios</a></li>
                        <li @click="menu=3"><a href="javascript:void(0)">Categorías</a></li>
                        <li @click="menu=4"><a href="javascript:void(0)">Actividades</a></li>
                        <li @click="menu=24"><a href="javascript:void(0)">VIP <i class="fa fa-star text-warning" aria-hidden="true"></i> </a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-wrench" aria-hidden="true"></i><span class="hide-menu">Herramientas </span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li @click="menu=6"><a href="javascript:void(0)">Mi cuenta</a></li>
                        <li @click="menu=7"><a href="javascript:void(0)">Documentos a pedido</a></li>
                        <li @click="menu=8"><a href="javascript:void(0)">Black list</a></li>
                        <li @click="menu=9"><a href="javascript:void(0)">Tipificador dt</a></li>
                        <li @click="menu=10"><a href="javascript:void(0)">Sorteos</a></li>
                        <li @click="menu=11"><a href="javascript:void(0)">Promociones</a></li>
                        {{--  <li @click="menu=12"><a href="javascript:void(0)">BENEFICIOS</a></li> --}}
                        <li @click="menu=13"><a href="javascript:void(0)">Seminarios</a></li>
                        <li @click="menu=14"><a href="javascript:void(0)">Visitas a terreno</a></li>
                        <li @click="menu=15"><a href="javascript:void(0)">Tips</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-commenting-o" aria-hidden="true"></i><span class="hide-menu">Feedback </span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li @click="menu=16"><a href="javascript:void(0)">Sugerencías</a></li>
                        <li @click="menu=18"><a href="javascript:void(0)">Asesoría y cotiza hoy</a></li>
                        <li @click="menu=19"><a href="javascript:void(0)">Compartir documento</a></li>
                        <li @click="menu=20"><a href="javascript:void(0)">Alertas</a></li>
                        <li @click="menu=23"><a href="javascript:void(0)">Contácto</a></li>
                        <li @click="menu=21"><a href="javascript:void(0)">Reclutamiento</a></li>
                        <li @click="menu=22"><a href="javascript:void(0)">Like y dislike</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-list" aria-hidden="true"></i><span class="hide-menu">Informes </span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li @click="menu=16"><a href="javascript:void(0)">Ventas contenido</a></li>
                        <li @click="menu=17"><a href="javascript:void(0)">Clientes activos</a></li>
                    </ul>
                </li>
            </ul>

            <ul id="sidebarnav" v-show="ubicacion == 1  && menu_administrador == 1">
                <li class="nav-small-cap">--- ¿Ver cómo?</li>

                <li v-if="menu_administrador==0">
                    <a @click="menu_administrador=1" class="waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i><span class="hide-menu">Usuario </span></a>
                </li>
                <li v-if="menu_administrador==1">
                    <a @click="menu_administrador=0" class="waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i><span class="hide-menu">Administrador </span></a>
                </li>

                <li class="nav-small-cap">--- HERRAMIENTAS</li>
                <li @click="menu=0"><a class="waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-home"></i><span class="hide-menu"> Escritorio</span></a></li>
                <li @click="menu=1"><a class="waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-user"></i><span class="hide-menu"> Mi perfil</span></a></li>
                <li @click="menu=12"><a class="waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-usd"></i><span class="hide-menu"> Recargar</span></a></li>
                <li @click="menu=2"><a class="waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-search"></i><span class="hide-menu"> Pide documento</span></a></li>
                <usuario-sorteos></usuario-sorteos>
                <usuario-promociones></usuario-promociones>
                <usuario-seminarios></usuario-seminarios>
                <li @click="menu=7"><a class="waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-car"></i><span class="hide-menu"> Visitas a terreno</span></a></li>
                <recomendar></recomendar>
                <li class="nav-small-cap">--- FEEDBACK</li>
                <li><a class="waves-effect waves-dark" href="https://api.whatsapp.com/send?phone=56944995688&text=Cont%C3%A1cto%20desde%20PREVENCIONLEBENCO.CL" target="_blank" aria-expanded="false"><i class="fa fa-envelope"></i><span class="hide-menu"> Contactenos</span></a></li>
                <li @click="menu=11"><a class="waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-cloud-upload"></i><span class="hide-menu"> Subir documento</span></a></li>
            </ul>
        </nav>
    </div>
</aside>

<template v-if="ubicacion == 0 && menu==0">
    <general></general>
</template>

<template v-if="ubicacion == 0 && menu==1">
    <sliders></sliders>
</template>

<template v-if="ubicacion == 0 && menu==2">
    <nosotros></nosotros>
</template>

<template v-if="ubicacion == 0 && menu==3">
    <comunidad></comunidad>
</template>

<template v-if="ubicacion == 0 && menu==4">
    <servicios></servicios>
</template>

<template v-if="ubicacion == 0 && menu==5">
    <login></login>
</template>

<template v-if="ubicacion == 0 && menu==6">
    <interes></interes>
</template>

<template v-if="ubicacion == 0 && menu==7">
    <home-intranet></home-intranet>
</template>

<template v-if="ubicacion == 0 && menu==8">
    <sliders-comunidad></sliders-comunidad>
</template>

<template v-if="ubicacion == 0 && menu==9">
    <avatares></avatares>
</template>

<template v-if="ubicacion == 1 && menu==0 && menu_administrador == 0">
    <categoria-documentos></categoria-documentos>
</template>

<template v-if="ubicacion == 1 && menu==1 && menu_administrador == 0">">
    <documentos :tipo="1" :tipo_documento="1" :titulo="'Documentos Aprobados'" :tipo_usuario="{{ Auth::user()->tipo_usuario }}"></documentos>
</template>

<template v-if="ubicacion == 1 && menu==2 && menu_administrador == 0">">
    <documentos :tipo="2" :tipo_documento="0" :titulo="'Documentos Pendientes'" :tipo_usuario="{{ Auth::user()->tipo_usuario }}"></documentos>
</template>

<template v-if="ubicacion == 1 && menu==3 && menu_administrador == 0">">
    <categorias-usuario></categorias-usuario>
</template>

<template v-if="ubicacion == 1 && menu==4 && menu_administrador == 0">">
    <profesiones-rubros></profesiones-rubros>
</template>

<template v-if="ubicacion == 1 && menu==5 && menu_administrador == 0">">
    <usuarios></usuarios>
</template>

<template v-if="ubicacion == 1 && menu==6 && menu_administrador == 0">">
    <perfil :usuario_id="{{ json_encode(Auth::user()->id) }}" :tipo_usuario_logeado="{{ json_encode(Auth::user()->tipo_usuario) }}"></perfil>
</template>

<template v-if="ubicacion == 1 && menu==7 && menu_administrador == 0">">
    <solicitud-documentos></solicitud-documentos>
</template>


<template v-if="ubicacion == 1 && menu==8 && menu_administrador == 0">">
    <usuarios-black-list></usuarios-black-list>
</template>

<template v-if="ubicacion == 1 && menu==10 && menu_administrador == 0">">
    <sorteos :tipo_usuario="{{ Auth::user()->tipo_usuario }}" :tipo="1"></sorteos>
</template>

<template v-if="ubicacion == 1 && menu==11 && menu_administrador == 0">">
    <promociones :tipo="1" :tipo_usuario="{{ Auth::user()->tipo_usuario }}"></promociones>
</template>

<template v-if="ubicacion == 1 && menu==13 && menu_administrador == 0">">
    <seminarios :tipo_usuario="{{ Auth::user()->tipo_usuario }}" :tipo="1"></seminarios>
</template>

<template v-if="ubicacion == 1 && menu==14 && menu_administrador == 0">">
    <asesorias></asesorias>
</template>

<template v-if="ubicacion == 1 && menu==15 && menu_administrador == 0">">
    <tips></tips>
</template>

<template v-if="ubicacion == 1 && menu==20 && menu_administrador == 0">">
    <alertas ref="componente_alerta"></alertas>
</template>

<template v-if="ubicacion == 1 && menu==23 && menu_administrador == 0">">
    <alertas-contacto ref="componente_alerta"></alertas-contacto>
</template>

<template v-if="ubicacion == 1 && menu==24 && menu_administrador == 0">">
    <tabla-vip></tabla-vip>
</template>



<template v-if="ubicacion == 1 && menu==0 && menu_administrador == 1">
    <escritorio @if(Auth::user()->last_login_at == null && Auth::user()->created_at->format('Y-m-d H:i') == Carbon\Carbon::now()->format('Y-m-d H:i')) :mensaje="1"  @endif ></escritorio>
</template>

<template v-if="ubicacion == 1 && menu == 1 && menu_administrador == 1">
    <perfil  :usuario_id="{{ json_encode(Auth::user()->id) }}" :tipo_usuario_logeado="{{ json_encode(Auth::user()->tipo_usuario) }}"></perfil>
</template>

<template v-if="ubicacion == 1 && menu==2 && menu_administrador == 1">
    <solicitud-documentos></solicitud-documentos>
</template>

<template v-if="ubicacion == 1 && menu==3 && menu_administrador == 1">
    <sorteos :tipo_usuario="{{ Auth::user()->tipo_usuario }}" :tipo="2"></sorteos>
</template>

<template v-if="ubicacion == 1 && menu==4 && menu_administrador == 1">
    <promociones :tipo_usuario="{{ Auth::user()->tipo_usuario }}" :tipo="2"></promociones>
</template>

<template v-if="ubicacion == 1 && menu==6 && menu_administrador == 1">
    <seminarios :tipo_usuario="{{ Auth::user()->tipo_usuario }}" :tipo="2"></seminarios>
</template>

<template v-if="ubicacion == 1 && menu==7 && menu_administrador == 1">
    <solicitar-asesoria></solicitar-asesoria>
</template>

<template v-if="ubicacion == 1 && menu==11 && menu_administrador == 1">
    <documentos :tipo="3" :tipo_documento="0" :titulo="'Comparte tu documento'" :tipo_usuario="{{ Auth::user()->tipo_usuario }}"></documentos>
</template>

<template v-if="ubicacion == 1 && menu==12 && menu_administrador == 1">
    <recargas></recargas>
</template>

<template v-if="ubicacion == 1 && menu==13 && menu_administrador == 1">
    <resultados-busqueda></resultados-busqueda>
</template>


