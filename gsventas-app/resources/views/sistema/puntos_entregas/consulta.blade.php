@extends('adminlte::page')

@section('title', 'edit')

@section('content_header')
    <h1 class="m-0">{{ $producto->catalogo }}</h1>
@stop

@section('content')
    @include('partials.aviso')
    <section class="content">
        <p>Ingrese las modificaciones del producto</p>
        <div class="card">
            @if (session()->has('message') && session('message') == 'ok')
                <x-adminlte-alert theme="success" title="MODIFICADO!">
                    El producto ha sido modificado de manera exitosa!
                </x-adminlte-alert>
            @endif
            <div class="card-body">
                <form action="{{ route('productos.update', $producto) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Columna izquierda -->
                            @include('partials.input', [
                                'name' => 'catalogo',
                                'placeholder' => 'Catalogo / Modelo / Nombre',
                                'icon' => 'bi bi-tag',
                                'label' => 'Catalogo / Modelo / Nombre',
                                'value' => $producto->catalogo,
                                'label-class' => 'text-primary',
                            ])
                            @include('partials.textarea', [
                                'name' => 'descripcion',
                                'label' => 'Ingrese el domicilio...',
                                'value' => $producto->descripcion,
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
                                'label' => 'Precio del producto con (Maximo 2 decimales)',
                                'value' => $producto->precio,
                                'label-class' => 'text-primary',
                            ])
                            @include('partials.input', [
                                'name' => 'costo',
                                'placeholder' => 'Costo del producto con (Maximo 2 decimales)',
                                'icon' => 'bi bi-receipt',
                                'label' => 'Costo del producto con (Maximo 2 decimales)',
                                'value' => $producto->costo,
                                'label-class' => 'text-primary',
                            ])
                        </div>
                    </div>
                    <!-- Contenedor del botonera -->
                    <div class="row mt-3">
                        <div class="col-md-12 d-flex justify-content-end">
                            <x-adminlte-button id="deleteButton" class="btn-danger" icon="bi bi-trash" label="Eliminar" />
                            <x-adminlte-button type="submit" class="btn-primary" icon="bi bi-floppy" label="Actualizar" />
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
                const deleteUrl = "{{ route('productos.destroy', $producto->id) }}";
                const csrfToken = $('meta[name="csrf-token"]').attr('content');

                Swal.fire({
                    title: '¿Estás seguro de que quieres eliminar el producto {{ $producto->catalogo }}?',
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
                                        text: 'El producto ha sido eliminado exitosamente.',
                                        icon: 'success'
                                    }).then(() => {
                                        window.location.href =
                                            "{{ route('productos.index') }}"; // Redirigir a la página de productos
                                    });
                                } else {
                                    // Si el servidor devuelve un mensaje de error
                                    Swal.fire({
                                        title: 'Error',
                                        text: response.message ||
                                            'Ocurrió un error al eliminar el producto. Intenta nuevamente.',
                                        icon: 'error'
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                // Si hay un error con la solicitud
                                console.error('Error eliminando el producto:', error);
                                Swal.fire({
                                    title: 'Error',
                                    text: 'Ocurrió un error al eliminar el producto. Intenta nuevamente.',
                                    icon: 'error'
                                });
                            }
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire({
                            title: 'Cancelado',
                            text: 'El producto no ha sido eliminado.',
                            icon: 'error'
                        });
                    }
                });
            });
        });
    </script>
@stop
