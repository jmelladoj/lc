<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recuperar Contraseña</title>
    <style>
        p {
            color: #1E2F13;
        }

        .icono {
            width: 80px;
            margin: 10px 10px 10px 10px;
            float: left;
        }

        .iconos {
            width: 400px;
            height: 60px;
        }

        .activo {
            color: #8AB733;
        }
    </style>
</head>
<body>
    <center>
        <p>
            <img src="{{ asset('intranet/img_mail/logo.png') }}" height="150" width="auto" />
        </p>
        <p>
            <h3>Hola!</h3>
        </p>

        <br><br>

        <p>
            <b>{{ $usuario->nombre }}</b>, esta es tu clave provisoria: <b>{{ $clave }}</b> <br>
            Si no puedes recuperar tu cuenta, contacta al equipo de <a href="#">soporte@prevencionlebenco.cl</a>.
        </p>

        <br><br>

        <div class="iconos">
            <div class="icono" style="display: none;">
                <a target="_blank" href="https://www.youtube.com/channel/UC78DsrgVX7KslItHoTuw8uQ?view_as=subscriber" class="activo">
                    <img src="{{ asset('intranet/img_mail/youtube.png') }}" height="50" width="auto" alt="">
                </a>
            </div>
            <div class="icono">
                <a target="_blank" href="https://www.facebook.com/prevencion.lebenco.3" class="activo">
                    <img src="{{ asset('intranet/img_mail/facebook.png') }}" height="50" width="auto" alt="">
                </a>
            </div>
            <div class="icono">
                <a target="_blank" href="https://www.instagram.com/prevencionlebenco.cl/?hl=es-la" class="activo">
                    <img src="{{ asset('intranet/img_mail/instagram.png') }}" height="50" width="auto" alt="">
                </a>
            </div>
            <div class="icono" style="display: none;">
                <a target="_blank" href="https://www.linkedin.com/in/prevenci%C3%B3n-lebenco-62b632184/" class="activo">
                    <img src="{{ asset('intranet/img_mail/linkedin.png') }}" height="50" width="auto" alt="">
                </a>
            </div>
        </div>

        <br><br>

        <p>
            Disfruta nuestras redes sociales y recomienda el sitio web <a href="www.prevencionlebenco.cl" target="_blank">prevencionlebenco.cl</a> a tus amigos.
        </p>

        <br><br>

        <img src="{{ asset('intranet/img_mail/pie.png') }}" height="80" width="auto" />
    </center>
</body>
</html>
