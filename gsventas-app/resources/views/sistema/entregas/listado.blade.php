@extends('adminlte::page')

@section('title', 'Principal')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">Listado de entregas</h1>
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
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Cliente</th>
                            <th>Cobrar</th>
                            <th>Venta</th>
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
                ajax: "{{ route('entregas.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'status',
                        name: 'status',
                    },
                    {
                        data: 'fecha',
                        name: 'fecha',
                    },
                    {
                        data: 'hora',
                        name: 'hora',
                    },
                    {
                        data: 'socio',
                        name: 'socio'
                    },
                    {
                        data: 'cobrar_cliente',
                        name: 'cobrar_cliente',
                    },
                    {
                        data: 'idventa',
                        name: 'idventa'
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
