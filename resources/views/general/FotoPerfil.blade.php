{{-- <div class="user-profile">
    <div class="user-pro-body">
        <div><img id="imagen_perfil_usuario" name="imagen_perfil_usuario" src="{{ Auth::user()->url_perfil == 'img/perfil.png' ? Auth::user()->url_perfil : 'storage/' . Auth::user()->url_perfil  }}" alt="Imagen perfil" class="img-circle"></div>
        <div class="dropdown">
            <a @click="menu=1" href="javascript:void(0)" class="dropdown-toggle u-dropdown link hide-menu" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <b>{{ Auth::user()->nombre }}</b><br>
                <b>{{ Auth::user()->categoria->nombre . ' - ' . Auth::user()->categoria->nivel }} <br> {{ Auth::user()->persona }} </b>

                <span class="caret"></span>
            </a>
            @if(Auth::user()->email == 'j.melladojimenez@hotmail.com' || Auth::user()->email == 'prevencionlebenco@gmail.com')
                <div class="dropdown-menu animated flipInY">
                    <a href="/cambio/usuario/4" class="dropdown-item"> Administrador</a>
                    <a href="/cambio/usuario/1" class="dropdown-item"> Persona</a>
                    <a href="/cambio/usuario/3" class="dropdown-item"> Estudiante</a>
                    <a href="/cambio/usuario/2" class="dropdown-item"> Pyme</a>
                </div>
            @endif
        </div>
    </div>
</div> --}}

<div class="user-profile">
    <div class="user-pro-body">
        <div><img id="imagen_perfil_usuario" name="imagen_perfil_usuario" src="{{ Auth::user()->url_perfil == 'img/perfil.png' ? Auth::user()->url_perfil : 'storage/' . Auth::user()->url_perfil  }}" alt="Imagen perfil" class="pl-1 pr-1 img-fluid" style="height: auto;"></div>
        <div class="dropdown">
            <a @click="menu=1" href="javascript:void(0)" class="dropdown-toggle u-dropdown link hide-menu" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <b>{{ Auth::user()->nombre }}</b><br>
                <b>{{ Auth::user()->categoria->nombre . ' - ' . Auth::user()->categoria->nivel }} <br> {{ Auth::user()->persona }} </b>

                <span class="caret"></span>
            </a>
            @if(Auth::user()->email == 'j.melladojimenez@hotmail.com' || Auth::user()->email == 'prevencionlebenco@gmail.com')
                <div class="dropdown-menu animated flipInY">
                    <a href="/cambio/usuario/4" class="dropdown-item"> Administrador</a>
                    <a href="/cambio/usuario/1" class="dropdown-item"> Persona</a>
                    <a href="/cambio/usuario/3" class="dropdown-item"> Estudiante</a>
                    <a href="/cambio/usuario/2" class="dropdown-item"> Pyme</a>
                </div>
            @endif
        </div>
    </div>
</div>
