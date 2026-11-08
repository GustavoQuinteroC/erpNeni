@extends('adminlte::page')

@section('title', 'Principal')

@section('content_header')
    <h1 class="m-0">Registro de usuario</h1>
@stop

@section('content')
    @include('partials.aviso')
    <section class="content">
        <p>Ingrese la información del usuario</p>
        <div class="card">
            @if (session()->has('message') && session('message') == 'ok')
                <x-adminlte-alert theme="success" title="MODIFICADO!">
                    El usuario se ha guardado de manera exitosa!
                </x-adminlte-alert>
            @endif
            <div class="card-body">
                <form action="{{ route('usuarios.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Columna izquierda -->
                            @include('partials.input', [
                                'name' => 'name',
                                'placeholder' => 'Nombre Completo',
                                'icon' => 'bi bi-person',
                                'label' => 'Nombre Completo',
                                'label-class' => 'text-primary',
                            ])
                            @include('partials.input', [
                                'name' => 'email',
                                'type' => 'email',
                                'placeholder' => 'Correo (correo@ejemplo.com)',
                                'icon' => 'bi bi-at',
                                'label' => 'Correo (correo@ejemplo.com)',
                                'label-class' => 'text-primary',
                            ])
                            @include('partials.input', [
                                'name' => 'telefono',
                                'placeholder' => 'Teléfono (10 Digitos)',
                                'icon' => 'bi bi-telephone',
                                'label' => 'Teléfono (10 Digitos)',
                                'label-class' => 'text-primary',
                            ])
                            @include('partials.input', [
                                'name' => 'ine',
                                'placeholder' => 'INE (IDEMEX...)',
                                'icon' => 'bi bi-person-vcard',
                                'label' => 'INE (IDEMEX...)',
                                'label-class' => 'text-primary',
                            ])
                        </div>
                        <div class="col-md-6">
                            <!-- Columna derecha -->
                            @include('partials.input', [
                                'name' => 'domicilio',
                                'placeholder' => 'Domicilio',
                                'icon' => 'bi bi-house',
                                'label' => 'Domicilio',
                                'label-class' => 'text-primary',
                            ])
                            @include('partials.input', [
                                'name' => 'rfc',
                                'placeholder' => 'RFC (Con homoclave)',
                                'icon' => 'bi bi-person-vcard',
                                'label' => 'RFC (Con homoclave)',
                                'label-class' => 'text-primary',
                            ])
                            @include('partials.input', [
                                'name' => 'password',
                                'type' => 'password',
                                'placeholder' => 'Contraseña',
                                'icon' => 'bi bi-key',
                                'label' => 'Contraseña',
                                'label-class' => 'text-primary',
                            ])
                        </div>
                    </div>
                    <!-- Contenedor del botonera -->
                    <div class="row mt-3">
                        <div class="col-md-12 d-flex justify-content-end">
                            @include('partials.button', [
                                'type' => 'submit',
                                'label' => 'Guardar',
                                'theme' => 'primary',
                                'icon' => 'bi bi-floppy',
                            ])
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@stop
