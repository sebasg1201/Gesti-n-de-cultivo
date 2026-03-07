@component('mail::message')
# ¡Bienvenido(a) a {{ $empresaName }}!

Hola **{{ $adminName }}**,

Tu cuenta de administrador ha sido creada exitosamente.

A continuación, encontrarás tus credenciales de acceso para ingresar a la plataforma:

- **Correo electrónico:** {{ $email }}
- **Contraseña:** {{ $password }}

*Por tu seguridad, te recomendamos cambiar la contraseña una vez inicies sesión por primera vez.*

En el archivo adjunto encontrarás un **PDF** con un resumen de tu cuenta y el plan de licencia asociado a la empresa.

@component('mail::button', ['url' => route('usuario.login')])
Iniciar Sesión
@endcomponent

Saludos,<br>
{{ config('app.name') }}
@endcomponent