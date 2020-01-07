<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contacto desde pagina web</title>
</head>
<body>
    Datos del remitente: <br><br>

    Remitente: {{ $nombre }}<br>
    Número: {{ $numero }}<br>
    Email: {{ $email }}<br>
    Tipo de persona:

    @if($tipo_persona == 1)
        Persona
    @elseif($tipo_persona == 2)
        Empresa
    @else
        Estudiante
    @endif
    <br><br>

    Datos del mensaje: <br>
    Asunto: {{ $asunto }} <br>
    Mensaje: {{ $mensaje }}
</body>
</html>
