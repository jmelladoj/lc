<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bienvenida</title>
</head>
<body>
    Hola {{ $usuario->nombre }}, gracias por unirte a nuestra comunidad.

    @if($usuario->mailing == 1)
        Pronto te estaremos enviado información.
    @endif
</body>
</html>
