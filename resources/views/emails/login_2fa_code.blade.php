<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Código de Verificación - AgroTech</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7f6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.05);
        }
        .header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            padding: 40px 20px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 900;
            letter-spacing: -1px;
        }
        .content {
            padding: 40px;
            text-align: center;
        }
        .content p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        .code-container {
            background-color: #f0fdf4;
            border: 2px dashed #10b981;
            border-radius: 16px;
            padding: 30px;
            margin: 20px 0;
            display: inline-block;
        }
        .code {
            font-size: 48px;
            font-weight: 900;
            letter-spacing: 12px;
            color: #065f46;
            margin: 0;
            padding-left: 12px;
        }
        .footer {
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #999;
            background-color: #fafafa;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>AgriManager</h1>
        </div>
        <div class="content">
            <h2>Verifica tu inicio de sesión</h2>
            <p>Hola Administrador, alguien está intentando acceder a tu cuenta. <br>Utiliza el siguiente código para completar el inicio de sesión:</p>
            
            <div class="code-container">
                <p class="code">{{ $code }}</p>
            </div>

            <p>Este código es válido por los próximos 10 minutos. <br> Si tú no solicitaste este acceso, por favor ignora este correo.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} AgroTech - Gestión de Cultivo Inteligente.
        </div>
    </div>
</body>
</html>
