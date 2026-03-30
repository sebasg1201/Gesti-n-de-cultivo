<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px; }
        .header { background-color: #10b981; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { padding: 20px; }
        .footer { font-size: 12px; color: #777; text-align: center; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>¡Bienvenido a {{ config('app.name') }}!</h1>
        </div>
        <div class="content">
            <p>Hola, <strong>{{ $usuario->nombre }}</strong>,</p>
            <p>Es un gusto darte la bienvenida a nuestro equipo de trabajo. Se ha creado tu cuenta de acceso al sistema de gestión de cultivos.</p>
            <p>Adjunto a este correo encontrarás un documento PDF con tus credenciales de acceso iniciales (Documento y Contraseña).</p>
            <p>Por favor, mantén esta información segura.</p>
            <p>Saludos,<br>El equipo de administración.</p>
        </div>
        <div class="footer">
            Este es un correo automático, por favor no respondas a este mensaje.
        </div>
    </div>
</body>
</html>
