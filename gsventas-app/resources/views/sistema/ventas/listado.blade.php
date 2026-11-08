@extends('adminlte::page')

@section('title', 'Principal')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">Listado de ventas</h1>
        <a href="{{ route('ventas.create') }}" class="btn btn-primary">Nuevo registro</a>
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
                            <th>ID Entrega</th>
                            <th>Estado</th>
                            <th>Cliente</th>
                            <th>Entregara</th>
                            <th>Fecha venta</th>
                            <th>Fecha entrega</th>
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
                ajax: "{{ route('ventas.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'identrega',
                        name: 'identrega'
                    },
                    {
                        data: 'statusEntrega',
                        name: 'statusEntrega'
                    },
                    {
                        data: 'socio',
                        name: 'socio'
                    },
                    {
                        data: 'usuarioEntrega',
                        name: 'usuarioEntrega'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data, type, full, meta) {
                            // Extraer solo la parte de la fecha
                            var fecha = data.split('T')[0];
                            return fecha;
                        }
                    },
                    {
                        data: 'fechaEntrega',
                        name: 'fechaEntrega',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                // Configuración para el idioma español
                language: {
                    "url": "//cdn.datatables.net/plug-ins/2.3.8/i18n/es-ES.json"
                },
                // Configuración adicional para hacer la tabla responsiva y centrar el contenido
                autoWidth: false,
                columnDefs: [{
                        targets: [3],
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
