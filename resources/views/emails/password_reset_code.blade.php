<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Código de inicio de sesión - AgroTech</title>
</head>

<body style="margin:0; padding:0; background-color:#f3f4f6; font-family:Arial, Helvetica, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="padding:30px 0;">
        <tr>
            <td align="center">

                <!-- CONTENEDOR -->
                <table width="550" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:16px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,0.08);">

                    <!-- IMAGEN HERO -->
                    <tr>
                        <td>
                            <img src="https://images.unsplash.com/photo-1563514227147-6d2ff665a6a0"
                                alt="AgroTech"
                                width="600"
                                style="display:block; width:100%; height:auto;">
                        </td>
                    </tr>

                    <!-- CONTENIDO -->
                    <tr>
                        <td style="padding:40px; text-align:left;">

                            <h1 style="margin:0 0 15px; font-size:26px; color:#111827;">
                                Código de cambio de contraseña
                            </h1>

                            <p style="margin:0 0 25px; font-size:15px; color:#6b7280;">
                                Este es tu código para cambiar tu contraseña
                                <strong style="color:#16a34a;">AgroTech</strong>
                            </p>

                            <!-- CÓDIGO -->
                            <div style="
                                background:#ecfdf5;
                                border:2px solid #16a34a;
                                border-radius:12px;
                                padding:22px;
                                text-align:center;
                                margin-bottom:25px;
                            ">
                                <span style="
                                font-size:32px;
                                font-weight:bold;
                                letter-spacing:8px;
                                color:#166534;
                            ">
                                    {{ $code }}
                                </span>
                            </div>

                            <p style="font-size:14px; color:#6b7280; margin-bottom:20px;">
                                Este código expirará en unos minutos.
                            </p>

                            <!-- SEGURIDAD -->
                            <div style="
                                background:#f9fafb;
                                border-left:4px solid #16a34a;
                                padding:15px;
                                font-size:13px;
                                color:#374151;
                            ">
                                Si tú no solicitaste este código, te recomendamos ignorar este correo
                                Y ponerse en contacto con nosotros.
                            </div>

                        </td>
                    </tr>

                    <!-- FOOTER -->
                    <tr>
                        <td style="background:#f9fafb; text-align:center; padding:20px; font-size:12px; color:#9ca3af;">
                            © {{ date('Y') }} AgroTech. Todos los derechos reservados.
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>