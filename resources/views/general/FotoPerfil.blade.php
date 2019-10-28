<div class="user-profile">
    <div class="user-pro-body">
        <div><img src="{{ asset(Auth::user()->url_perfil) }}" alt="Imagen perfil" class="img-circle"></div>
        <div class="dropdown">
            <a href="javascript:void(0)" class="dropdown-toggle u-dropdown link hide-menu" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <b>{{ Auth::user()->nombre }}</b><br>
                <b>{{ Auth::user()->categoria->nombre . ' - ' . Auth::user()->categoria->nivel }}</b>

                <span class="caret"></span>
            </a>
            <div class="dropdown-menu animated flipInY">
                <a href="#" class="dropdown-item"><i class="fa fa-user"></i> Mi perfil</a>
                <div class="dropdown-divider"></div>
            </div>
        </div>
    </div>
</div>