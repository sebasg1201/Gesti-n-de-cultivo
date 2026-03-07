<!DOCTYPE html>
<html>
<head>
    <title>Nuevo Mensaje de Contacto</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="max-w-xl mx-auto bg-white p-6 rounded-lg shadow-md border-t-4 border-green-500">
        <h2 style="color: #10B981;">Nuevo Mensaje desde el Panel de Admin</h2>
        
        <p><strong>De:</strong> {{ $datosMail['nombre_usuario'] }} ({{ $datosMail['correo_usuario'] }})</p>
        <p><strong>Empresa ID:</strong> {{ $datosMail['id_empresa'] }}</p>
        <p><strong>Asunto:</strong> {{ $datosMail['asunto'] }}</p>
        
        <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
        
        <p><strong>Mensaje:</strong></p>
        <p style="background-color: #f9f9f9; padding: 15px; border-radius: 5px; color: #333;">
            {{ nl2br(e($datosMail['mensaje'])) }}
        </p>
        
        <br>
        <p style="color: #666; font-size: 12px;">Este correo fue generado automáticamente desde AgriManager.</p>
    </div>
</body>
</html>
