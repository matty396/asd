<DOCTYPE html />
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <p>Hola {{$data['name']}},</p>

        <p>Nosotros necesitamos verificar tu correo antes de ingresar a tu cuenta.</p>

        <p>Verifica tu correo electrónico en el siguiente enlace
        <i><a href="{{$data['verification_link']}}">Verificar Tu Cuenta</a></i>.</p>
        <br/>


        <p>Muchas Gracias! – El equipo de <strong>{{$data['company']}}</strong></p>
    </body>
</html>
