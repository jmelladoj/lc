<aside class="left-sidebar">
    <div class="scroll-sidebar">
        @include('general.FotoPerfil')

        <nav class="sidebar-nav">
            <ul id="sidebarnav" v-show="ubicacion == 1">
                <li class="nav-small-cap">--- HERRAMIENTAS</li>
                <li @click="menu=1"><a class="waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-user"></i><span class="hide-menu"> MI PERFIL</span></a></li>
                <li @click="menu=2"><a class="waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-search"></i><span class="hide-menu"> PIDE DOCUMENTO</span></a></li>
                <li @click="menu=3"><a class="waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-list-ol"></i><span class="hide-menu"> SORTEOS</span></a></li>
                <li @click="menu=4"><a class="waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-percent"></i><span class="hide-menu"> PROMOCIONES</span></a></li>
                <li @click="menu=5"><a class="waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-handshake-o"></i><span class="hide-menu"> BENEFICIOS</span></a></li>
                <li @click="menu=6"><a class="waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-calendar"></i><span class="hide-menu"> SEMINARIOS</span></a></li>
                <li @click="menu=7"><a class="waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-car"></i><span class="hide-menu"> VISITAS A TERRENO</span></a></li>
                <li @click="menu=8"><a class="waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-share-alt"></i><span class="hide-menu"> RECOMIÉNDANOS</span></a></li>

                <li class="nav-small-cap">--- FEEDBACK</li>
                <li @click="menu=9"><a class="waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-comment"></i><span class="hide-menu"> SUGERENCIAS</span></a></li>
                <li @click="menu=10"><a class="waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-envelope"></i><span class="hide-menu"> CONTÁCTENOS</span></a></li>
                <li @click="menu=11"><a class="waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-cloud-upload"></i><span class="hide-menu"> SUBIR DOCUMENTO</span></a></li>
            </ul>
        </nav>
    </div>
</aside>

<template v-if="ubicacion == 1 && menu==2">
    <solicitar-documento></solicitar-documento>
</template>

<template v-if="ubicacion == 1 && menu==3">
    <sorteos :tipo_usuario="{{ Auth::user()->tipo_usuario }}" :tipo="2"></sorteos>
</template>

<template v-if="ubicacion == 1 && menu==4">
    <promociones :tipo_usuario="{{ Auth::user()->tipo_usuario }}" :tipo="2"></promociones>
</template>

<template v-if="ubicacion == 1 && menu==7">
    <solicitar-asesoria></solicitar-asesoria>
</template>

<template v-if="ubicacion == 1 && menu==8">
    <recomendar></recomendar>
</template>

<template v-if="ubicacion == 1 && menu==11">
    <documentos :tipo="3" :tipo_documento="0" :titulo="'Comparte tu documento'" :tipo_usuario="{{ Auth::user()->tipo_usuario }}"></documentos>
</template>
    



