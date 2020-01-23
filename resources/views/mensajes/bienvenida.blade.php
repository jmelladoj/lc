<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Bienvenida</title>
    <style>
        p {
            color: #1E2F13;
        }

        .icono {
            width: 25%;
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

        <br><br>

        <p>
            <b>{{ $usuario->nombre }}</b>, ya eres parte de nuestra Comunidad. <br>
            Disfruta nuestras redes sociales y recomienda el sitio web <a href="www.prevencionlebenco.cl" target="_blank">prevencionlebenco.cl</a> a tus amigos.
        </p>

        <br><br>

        <p>
            <div class="icono">
                <a target="_blank" href="https://www.youtube.com/channel/UC78DsrgVX7KslItHoTuw8uQ?view_as=subscriber" class="activo"><i class="fa fa-youtube"></i></a>
            </div>
            <div class="icono"></div>
            <div class="icono"></div>
            <div class="icono"></div>
        </p>

        <br><br>

        <p>
            Sigue el link y pide tu primer documento:  <a href="www.prevencionlebenco.cl/login"><img src="{{ asset('intranet/img_mail/salir.png') }}" height="30" width="auto" /></a>

            @if($usuario->mailing == 1)
                Solo te enviaremos información relevante, para que estés informado y tomes decisiones.
                <br>
            @endif
        </p>

        <br><br>

        <img src="{{ asset('intranet/img_mail/pie.png') }}" height="150" width="auto" />
    </center>
</body>
</html>
