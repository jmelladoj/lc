<aside class="left-sidebar">
    <div class="scroll-sidebar">
        @include('general.FotoPerfil')

        <nav class="sidebar-nav">
            <ul id="sidebarnav" v-show="ubicacion == 1">
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

<template v-if="ubicacion == 1 && menu==0">
    <escritorio @if(Auth::user()->last_login_at == null && Auth::user()->created_at->format('Y-m-d H:i') == Carbon\Carbon::now()->format('Y-m-d H:i')) :mensaje="1"  @endif ></escritorio>
</template>

<template v-if="ubicacion == 1 && menu == 1">
    <perfil  :usuario_id="{{ json_encode(Auth::user()->id) }}" :tipo_usuario_logeado="{{ json_encode(Auth::user()->tipo_usuario) }}"></perfil>
</template>

<template v-if="ubicacion == 1 && menu==2">
    <solicitud-documentos></solicitud-documentos>
</template>

<template v-if="ubicacion == 1 && menu==3">
    <sorteos :tipo_usuario="{{ Auth::user()->tipo_usuario }}" :tipo="2"></sorteos>
</template>

<template v-if="ubicacion == 1 && menu==4">
    <promociones :tipo_usuario="{{ Auth::user()->tipo_usuario }}" :tipo="2"></promociones>
</template>

<template v-if="ubicacion == 1 && menu==6">
    <seminarios :tipo_usuario="{{ Auth::user()->tipo_usuario }}" :tipo="2"></seminarios>
</template>

<template v-if="ubicacion == 1 && menu==7">
    <solicitar-asesoria></solicitar-asesoria>
</template>

<template v-if="ubicacion == 1 && menu==11">
    <documentos :tipo="3" :tipo_documento="0" :titulo="'Comparte tu documento'" :tipo_usuario="{{ Auth::user()->tipo_usuario }}"></documentos>
</template>

<template v-if="ubicacion == 1 && menu==12">
    <recargas></recargas>
</template>

<template v-if="ubicacion == 1 && menu==13">
    <resultados-busqueda></resultados-busqueda>
</template>





