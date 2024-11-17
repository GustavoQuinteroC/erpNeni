@extends('adminlte::page')

@section('title', 'Principal')

@section('content_header')
    <h1 class="m-0 text-dark">{{ $cliente->name }}</h1>
@stop

@section('content')
    <section class="content">
        <p>Ingrese las modificaciones del cliente</p>
        <div class="card">
            @if (session()->has('message') && session('message') == 'ok')
                <x-adminlte-alert theme="success" title="MODIFICADO!">
                    El cliente ha sido modificado de manera exitosa!
                </x-adminlte-alert>
            @endif
            <div class="card-body">
                <form id="formEditarSocio" action="{{ route('clientes.update', $cliente) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            @include('partials.input', [
                                'name' => 'name',
                                'label' => 'Nombre Completo',
                                'value' => $cliente->name,
                                'icon' => 'fas fa-user',
                            ])
                            @include('partials.input', [
                                'name' => 'email',
                                'type' => 'email',
                                'label' => 'Correo (correo@ejemplo.com)',
                                'value' => $cliente->email,
                                'icon' => 'fas fa-at',
                            ])
                            @include('partials.input', [
                                'name' => 'telefono',
                                'label' => 'Telefono (10 Digitos)',
                                'value' => $cliente->telefono,
                                'icon' => 'fas fa-phone',
                            ])
                            @include('partials.select2', [
                                'name' => 'sexo',
                                'label' => 'Sexo...',
                                'placeholder' => 'Sexo...',
                                'options' => [
                                    'Indefinido' => 'Indefinido',
                                    'Hombre' => 'Hombre',
                                    'Mujer' => 'Mujer',
                                ],
                                'selected' => $cliente->sexo,
                            ])
                        </div>

                        <div class="col-md-6">
                            @include('partials.input', [
                                'name' => 'dias_entrega',
                                'label' => 'Dias de entrega',
                                'value' => $cliente->dias_entrega,
                                'icon' => 'fas fa-calendar-check',
                            ])
                            @include('partials.select2', [
                                'name' => 'plataforma',
                                'label' => 'Plataforma...',
                                'placeholder' => 'Plataforma...',
                                'options' => [
                                    'Facebook' => 'Facebook',
                                    'Alibaba' => 'Alibaba',
                                    'Aliexpress' => 'Aliexpress',
                                ],
                                'selected' => $cliente->plataforma,
                            ])
                            @include('partials.input', [
                                'name' => 'rfc',
                                'label' => 'RFC (Con homoclave)',
                                'value' => $cliente->rfc,
                                'icon' => 'fas fa-address-card',
                            ])
                            @include('partials.textarea', [
                                'name' => 'domicilio',
                                'label' => 'Ingrese el domicilio...',
                                'value' => $cliente->domicilio,
                                'icon' => 'fas fa-home',
                            ])
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 d-flex justify-content-end">
                            <x-adminlte-button id="deleteButton" class="btn-danger" icon="fas fa-trash" label="Eliminar"/>
                            <x-adminlte-button type="submit" class="btn-primary" icon="fas fa-save" label="Actualizar"/>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </section>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#deleteButton').click(function() {
                const deleteUrl = "{{ route('clientes.destroy', $cliente->id) }}";
                const csrfToken = $('meta[name="csrf-token"]').attr('content');

                Swal.fire({
                    title: '¿Estás seguro de que quieres eliminar al cliente {{ $cliente->name }}?',
                    text: 'Esta acción es irreversible.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, eliminar!',
                    cancelButtonText: 'No, cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: deleteUrl,
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        title: '¡Eliminado!',
                                        text: 'El cliente ha sido eliminado exitosamente.',
                                        icon: 'success'
                                    }).then(() => {
                                        window.location.href = "{{ route('clientes.index') }}"; // Redirigir a la página de socios
                                    });
                                } else {
                                    // Si el servidor devuelve un mensaje de error
                                    Swal.fire({
                                        title: 'Error',
                                        text: response.message || 'Ocurrió un error al eliminar el cliente. Intenta nuevamente.',
                                        icon: 'error'
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                // Si hay un error con la solicitud
                                console.error('Error eliminando el cliente:', error);
                                Swal.fire({
                                    title: 'Error',
                                    text: 'Ocurrió un error al eliminar el cliente. Intenta nuevamente.',
                                    icon: 'error'
                                });
                            }
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire({
                            title: 'Cancelado',
                            text: 'El cliente no ha sido eliminado.',
                            icon: 'error'
                        });
                    }
                });
            });
        });
    </script>
@stop