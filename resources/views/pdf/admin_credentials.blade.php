<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Credenciales de Administrador</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f6f8;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            color: #1a1a1a;
        }

        .wrapper {
            width: 100%;
            padding: 40px 0;
        }

        .container {
            width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }

        .header {
            padding: 30px 40px;
            border-bottom: 1px solid #e5e7eb;
        }

        .brand {
            font-size: 14px;
            font-weight: 600;
            color: #16a34a;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .title {
            margin-top: 8px;
            font-size: 22px;
            font-weight: 600;
            color: #111827;
        }

        .subtitle {
            margin-top: 5px;
            font-size: 14px;
            color: #6b7280;
        }

        .content {
            padding: 30px 40px;
            font-size: 14px;
            line-height: 1.6;
        }

        .content p {
            margin: 12px 0;
        }

        .name {
            font-weight: 600;
            color: #111827;
        }

        .section {
            margin-top: 25px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
            background-color: #fafafa;
        }

        .section-title {
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .label {
            color: #6b7280;
        }

        .value {
            font-weight: 500;
            color: #111827;
        }

        .divider {
            height: 1px;
            background: #e5e7eb;
            margin: 25px 0;
        }

        .note {
            margin-top: 20px;
            padding: 15px;
            border-left: 3px solid #16a34a;
            background-color: #f0fdf4;
            font-size: 13px;
            color: #166534;
        }

        .footer {
            padding: 20px 40px;
            font-size: 12px;
            color: #9ca3af;
            border-top: 1px solid #e5e7eb;
            text-align: center;
        }

        .footer strong {
            color: #6b7280;
        }
    </style>
</head>

<body>

    <div class="wrapper">
        <div class="container">

            <div class="header">
                <div class="brand">{{ config('app.name') }}</div>
                <div class="title">Acceso administrativo habilitado</div>
                <div class="subtitle">Credenciales y detalles de acceso</div>
            </div>

            <div class="content">
                <p>Estimado/a <span class="name">{{ $adminName }}</span>,</p>

                <p>
                    Su cuenta de administrador ha sido creada correctamente. A continuación se detallan
                    las credenciales de acceso y la información asociada a su organización.
                </p>

                <div class="section">
                    <div class="section-title">Credenciales de acceso</div>

                    <div class="row">
                        <div class="label">Correo electrónico</div>
                        <div class="value">{{ $email }}</div>
                    </div>

                    <div class="row">
                        <div class="label">Contraseña</div>
                        <div class="value">{{ $password }}</div>
                    </div>
                </div>

                <div class="section">
                    <div class="section-title">Información de la empresa</div>

                    <div class="row">
                        <div class="label">Empresa</div>
                        <div class="value">{{ $empresaName }}</div>
                    </div>

                    <div class="row">
                        <div class="label">Plan asignado</div>
                        <div class="value">{{ $planName }}</div>
                    </div>
                </div>

                <div class="note">
                    Por motivos de seguridad, se recomienda actualizar la contraseña en el primer inicio de sesión.
                </div>
            </div>

            <div class="footer">
                Este documento es confidencial y exclusivo para el destinatario.<br>
                <strong>{{ config('app.name') }}</strong> © {{ date('Y') }}. Todos los derechos reservados.
            </div>

        </div>
    </div>

</body>

</html>