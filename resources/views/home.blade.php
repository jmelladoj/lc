@extends('layouts.intranet')

@section('content')
    <aside class="left-sidebar">
        <div class="scroll-sidebar">
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
        <documentos :estado="1" :tipo_documento="1" :titulo="'Documentos Aprobados'"></documentos>
    </template>

    <template v-if="ubicacion == 1 && menu==2">
        <documentos :estado="1" :tipo_documento="0" :titulo="'Documentos Pendientes'"></documentos>
    </template>

    <template v-if="ubicacion == 1 && menu==3">
        <categorias-usuario></categorias-usuario>
    </template>

@endsection