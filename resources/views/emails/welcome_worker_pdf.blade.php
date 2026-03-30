<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Credenciales de Acceso</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #1f2937; line-height: 1.5; margin: 0; padding: 40px; }
        .header { text-align: center; border-bottom: 2px solid #10b981; padding-bottom: 20px; margin-bottom: 30px; }
        .logo { color: #059669; font-size: 24px; font-weight: bold; }
        .welcome-title { color: #111827; font-size: 22px; font-weight: 800; margin-bottom: 10px; }
        .card { background-color: #f9fafb; border: 1px solid #e5e7eb; border-radius: 12px; padding: 25px; margin: 30px 0; }
        .card-title { color: #374151; font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 15px; border-bottom: 1px solid #d1d5db; padding-bottom: 5px; }
        .credential-item { margin-bottom: 15px; }
        .label { color: #6b7280; font-size: 12px; font-weight: 600; text-transform: uppercase; }
        .value { color: #111827; font-size: 16px; font-weight: 700; font-family: monospace; }
        .security-notice { background-color: #fffbeb; border-left: 4px solid #fbbf24; padding: 15px; font-size: 13px; color: #92400e; margin-top: 20px; }
        .footer { text-align: center; font-size: 11px; color: #9ca3af; margin-top: 50px; border-top: 1px solid #f3f4f6; padding-top: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">AgroTech</div>
        <div class="welcome-title">Bienvenido al Equipo de Trabajo</div>
    </div>

    <p>Hola, <strong>{{ $usuario->nombre }}</strong>,</p>
    <p>Hemos activado tu cuenta de usuario para que puedas comenzar a gestionar tus tareas y actividades en el sistema.</p>

    <div class="card">
        <div class="card-title">Tus Credenciales de Acceso</div>
        
        <div class="credential-item">
            <span class="label">Documento de Identidad (Usuario):</span><br>
            <span class="value">{{ $usuario->documento }}</span>
        </div>

        <div class="credential-item">
            <span class="label">Contraseña de Acceso:</span><br>
            <span class="value">{{ $password }}</span>
        </div>

        <div class="credential-item">
            <span class="label">Rol Asignado:</span><br>
            <span class="value">{{ $usuario->id_tipo_usuario == 2 ? 'Supervisor' : 'Trabajador' }}</span>
        </div>
    </div>

    <div class="security-notice">
        <strong>AVISO DE SEGURIDAD:</strong> <br>
        Esta contraseña es privada y es de uso personal. Te recomendamos guardarla en un lugar seguro.
    </div>

    <p style="margin-top: 30px;">Puedes acceder al sistema desde el portal de inicio de sesión de la empresa.</p>

    <div class="footer">
        &copy; {{ date('Y') }} {{ config('app.name') }} - Sistema de Gestión de Cultivos Inteligente.
    </div>
</body>
</html>
