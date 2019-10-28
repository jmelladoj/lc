<aside class="left-sidebar">
    <div class="scroll-sidebar">
        @include('general.FotoPerfil')

        <nav class="sidebar-nav">
            <ul id="sidebarnav" v-show="ubicacion == 0">
                <li class="nav-small-cap">--- MENÚ</li>
                <li @click="menu=0"> <a class="waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-cog"></i><span class="hide-menu">GENERAL</span></a></li>
                <li @click="menu=1"><a class="waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-picture-o"></i><span class="hide-menu">SLIDERS</span></a></li>
                <li>
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-folder-o" aria-hidden="true"></i><span class="hide-menu">PÁGINAS </span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li @click="menu=2"><a href="javascript:void(0)">NOSOTROS</a></li>
                        <li @click="menu=3"><a href="javascript:void(0)">COMUNIDAD PYME</a></li>
                        <li @click="menu=4"><a href="javascript:void(0)">SERVICIOS</a></li>
                        <li @click="menu=5"><a href="javascript:void(0)">LOGIN</a></li>
                    </ul>
                </li>
                
            </ul>

            <ul id="sidebarnav" v-show="ubicacion == 1">
                <li class="nav-small-cap">--- MENÚ</li>
                <li>
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-folder-o" aria-hidden="true"></i><span class="hide-menu">CONTENIDO </span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li @click="menu=0"><a href="javascript:void(0)">CATEGORÍAS</a></li>
                        <li @click="menu=1"><a href="javascript:void(0)">DOCUMENTOS APROBADOS</a></li>
                        <li @click="menu=2"><a href="javascript:void(0)">DOCUMENTOS PENDIENTES</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-users" aria-hidden="true"></i><span class="hide-menu">CLIENTES </span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li @click="menu=3"><a href="javascript:void(0)">CATEGORÍAS USUARIO</a></li>
                        <li @click="menu=4"><a href="javascript:void(0)">PROFESIONES Y RUBROS</a></li>
                        <li @click="menu=5"><a href="javascript:void(0)">USUARIOS DEL SISTEMA</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-wrench" aria-hidden="true"></i><span class="hide-menu">HERRAMIENTAS </span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li @click="menu=6"><a href="javascript:void(0)">MI CUENTA</a></li>
                        <li @click="menu=7"><a href="javascript:void(0)">DOCUMENTOS A PEDIDO</a></li>
                        <li @click="menu=8"><a href="javascript:void(0)">BLACK LIST</a></li>
                        <li @click="menu=9"><a href="javascript:void(0)">TIPIFICADOR DT</a></li>
                        <li @click="menu=10"><a href="javascript:void(0)">SORTEOS</a></li>
                        <li @click="menu=11"><a href="javascript:void(0)">PROMOCIONES</a></li>
                        <li @click="menu=12"><a href="javascript:void(0)">BENEFICIOS</a></li>
                        <li @click="menu=13"><a href="javascript:void(0)">SEMINARIO</a></li>
                        <li @click="menu=14"><a href="javascript:void(0)">VISITAS A TERRENO</a></li>
                        <li @click="menu=15"><a href="javascript:void(0)">TIPS</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-commenting-o" aria-hidden="true"></i><span class="hide-menu">FEEDBACK </span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li @click="menu=16"><a href="javascript:void(0)">SUGERENCÍAS</a></li>
                        <li @click="menu=17"><a href="javascript:void(0)">CONTÁCTENOS</a></li>
                        <li @click="menu=18"><a href="javascript:void(0)">ASESORÍA Y COTIZA HOY</a></li>
                        <li @click="menu=19"><a href="javascript:void(0)">COMPARTIR DOCUMENTO</a></li>
                        <li @click="menu=20"><a href="javascript:void(0)">ALERTAS</a></li>
                        <li @click="menu=21"><a href="javascript:void(0)">RECLUTAMIENTO</a></li>
                        <li @click="menu=22"><a href="javascript:void(0)">LIKE Y DISLIKE</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-list" aria-hidden="true"></i><span class="hide-menu">INFORMES </span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li @click="menu=16"><a href="javascript:void(0)">VENTAS CONTENIDO</a></li>
                        <li @click="menu=17"><a href="javascript:void(0)">CLIENTES ACTIVO</a></li>
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

<template v-if="ubicacion == 1 && menu==5">
    <usuarios></usuarios>
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

<template v-if="ubicacion == 1 && menu==15">
    <tips></tips>
</template>