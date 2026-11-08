@extends('adminlte::page')

@section('title', 'Principal')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">Listado de productos</h1>
        <a href="{{ route('productos.create') }}" class="btn btn-primary">Nuevo registro</a>
    </div>
@stop

@section('content')
    @include('partials.aviso')
    <section class="content">
        <div class="card">
            <div class="card-body">
                <table id="table1" class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Catalogo</th>
                            <th>Precio</th>
                            <th>Costo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </section>
@stop


@section('js')
    <script>
        $(document).ready(function() {
            $('#table1').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('productos.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'catalogo',
                        name: 'catalogo'
                    },
                    {
                        data: 'precio',
                        name: 'precio'
                    },
                    {
                        data: 'costo',
                        name: 'costo'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                // Configuración adicional para hacer la tabla responsiva y centrar el contenido
                autoWidth: false,
                columnDefs: [{
                        targets: [1],
                        className: 'text-start'
                    }, // Alinear a la izquierda las columnas 1, 2 y 3
                    {
                        targets: [],
                        className: 'text-end'
                    }, // Alinear a la derecha las columnas 4 y 5
                    {
                        targets: '_all',
                        className: 'text-center'
                    } // Centrar el contenido de las demás columnas
                ]
            });
        });
    </script>
@stop

