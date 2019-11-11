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
                <li @click="menu=1"><a class="waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-picture-o"></i><span class="hide-menu">Sliders</span></a></li>
                <li>
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-folder-o" aria-hidden="true"></i><span class="hide-menu">Páginas </span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li @click="menu=2"><a href="javascript:void(0)">Nosotros</a></li>
                        <li @click="menu=3"><a href="javascript:void(0)">Comunidad Pyme</a></li>
                        <li @click="menu=4"><a href="javascript:void(0)">Servicios</a></li>
                        <li @click="menu=5"><a href="javascript:void(0)">Login</a></li>
                    </ul>
                </li>
                
                
            </ul>

            <ul id="sidebarnav" v-show="ubicacion == 1">
                <li class="nav-small-cap">--- Menú</li>
                <li>
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-folder-o" aria-hidden="true"></i><span class="hide-menu">Contenido </span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li @click="menu=0"><a href="javascript:void(0)">Categorías</a></li>
                        <li @click="menu=1"><a href="javascript:void(0)">Documentos aprobados</a></li>
                        <li @click="menu=2"><a href="javascript:void(0)">Documentos pendientes</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-users" aria-hidden="true"></i><span class="hide-menu">Clientes </span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li @click="menu=3"><a href="javascript:void(0)">Categorías USUARIO</a></li>
                        <li @click="menu=4"><a href="javascript:void(0)">Prefesiones y rubros</a></li>
                        <li @click="menu=5"><a href="javascript:void(0)">Usuarios del sistema</a></li>
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
                        <li @click="menu=13"><a href="javascript:void(0)">Seminariosc</a></li>
                        <li @click="menu=14"><a href="javascript:void(0)">Visitas a terreno</a></li>
                        <li @click="menu=15"><a href="javascript:void(0)">Tips</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-commenting-o" aria-hidden="true"></i><span class="hide-menu">Feedback </span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li @click="menu=16"><a href="javascript:void(0)">Sugerencías</a></li>
                        <li @click="menu=17"><a href="javascript:void(0)">Contáctenos</a></li>
                        <li @click="menu=18"><a href="javascript:void(0)">Asesoría y cotiza hoy</a></li>
                        <li @click="menu=19"><a href="javascript:void(0)">Compartir documento</a></li>
                        <li @click="menu=20"><a href="javascript:void(0)">Alertas</a></li>
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

<template v-if="ubicacion == 1 && menu==0">
    <categoria-documentos></categoria-documentos>
</template>

<template v-if="ubicacion == 1 && menu==1">
    <documentos :tipo="1" :tipo_documento="1" :titulo="'Documentos Aprobados'" :tipo_usuario="{{ Auth::user()->tipo_usuario }}"></documentos>
</template>

<template v-if="ubicacion == 1 && menu==2">
    <documentos :tipo="2" :tipo_documento="0" :titulo="'Documentos Pendientes'" :tipo_usuario="{{ Auth::user()->tipo_usuario }}"></documentos>
</template>

<template v-if="ubicacion == 1 && menu==3">
    <categorias-usuario></categorias-usuario>
</template>

<template v-if="ubicacion == 1 && menu==4">
    <profesiones-rubros></profesiones-rubros>
</template>

<template v-if="ubicacion == 1 && menu==5">
    <usuarios></usuarios>
</template>

<template v-if="ubicacion == 1 && menu==6">
    <perfil :usuario_id="{{ json_encode(Auth::user()->id) }}" :tipo_usuario_logeado="{{ json_encode(Auth::user()->tipo_usuario) }}"></perfil>
</template>

<template v-if="ubicacion == 1 && menu==7">
    <solicitud-documentos></solicitud-documentos>
</template>


<template v-if="ubicacion == 1 && menu==8">
    <usuarios-black-list></usuarios-black-list>
</template>

<template v-if="ubicacion == 1 && menu==10">
    <sorteos :tipo_usuario="{{ Auth::user()->tipo_usuario }}" :tipo="1"></sorteos>
</template>

<template v-if="ubicacion == 1 && menu==11">
    <promociones :tipo_usuario="{{ Auth::user()->tipo_usuario }}"></promociones>
</template>

<template v-if="ubicacion == 1 && menu==13">
    <seminarios :tipo_usuario="{{ Auth::user()->tipo_usuario }}" :tipo="1"></seminarios>
</template>

<template v-if="ubicacion == 1 && menu==14">
    <asesorias></asesorias>
</template>

<template v-if="ubicacion == 1 && menu==15">
    <tips></tips>
</template>