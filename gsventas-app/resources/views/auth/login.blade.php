@extends('adminlte::auth.login')

@section('auth_footer')
    <div class="alert alert-info mb-0 small" role="note">
        <strong>Demo de solo lectura</strong><br>
        Correo: <span class="user-select-all">{{ $demo['correo'] }}</span><br>
        Contraseña: <span class="user-select-all">{{ $demo['clave'] }}</span>
    </div>
@stop
