@component('mail::message')
# Recuperar Cuenta

Una petición para reestablecer la contraseña de su cuenta ha sido realizada en nuestro sitio web,
se redireccionará a una página donde puede cambiar su contraseña.

@component('mail::button', ['url' => 'http://localhost:4200/auth/response-reset-password?token='.$token])
Cambiar Contraseña
@endcomponent

Cordialmente,<br>
Equipo <strong>{{ config('app.name') }}</strong>
@endcomponent
