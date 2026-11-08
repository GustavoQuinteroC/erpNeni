@extends('adminlte::page')

@section('title', 'Principal')

@section('content_header')
    <h1 class="m-0">Registro de producto</h1>
@stop

@section('content')
    @include('partials.aviso')
    <section class="content">
        <p>Ingrese la información del producto</p>
        <div class="card">
            @if (session()->has('message') && session('message') == 'ok')
                <x-adminlte-alert theme="success" title="¡GUARDADO!">
                    El producto se ha guardado de manera exitosa!
                </x-adminlte-alert>
            @endif
            <div class="card-body">
                <form action="{{ route('productos.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Columna izquierda -->
                            @include('partials.input', [
                                'name' => 'catalogo',
                                'placeholder' => 'Catalogo / Modelo / Nombre',
                                'icon' => 'bi bi-tag',
                                'label' => 'Catalogo / Modelo / Nombre',
                                'label-class' => 'text-primary',
                            ])
                            @include('partials.textarea', [
                                'name' => 'descripcion',
                                'label' => 'Ingrese el domicilio...',
                                'placeholder' => 'Ingrese la descripcion del producto...',
                                'rows' => 3,
                                'icon' => 'bi bi-list',
                            ])
                        </div>
                        <div class="col-md-6">
                            <!-- Columna derecha -->
                            @include('partials.input', [
                                'name' => 'precio',
                                'placeholder' => 'Precio del producto con (Maximo 2 decimales)',
                                'icon' => 'bi bi-currency-dollar',
                                'label' => 'Precio del producto (Maximo 2 decimales)',
                                'label-class' => 'text-primary',
                            ])
                            @include('partials.input', [
                                'name' => 'costo',
                                'placeholder' => 'Costo del producto con (Maximo 2 decimales)',
                                'icon' => 'bi bi-receipt',
                                'label' => 'Costo del producto (Maximo 2 decimales)',
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
