@extends('adminlte::page')

@section('title', 'Comisiones de repartidores')

@section('content_header')
    <h1 class="m-0">Comisiones de repartidores por rango de fechas</h1>
@stop

@section('content')
    @include('partials.aviso')
    <div class="card">
        <div class="card-body">
            <form id="rango" class="row g-3 align-items-end mb-3">
                <div class="col-sm-4 col-lg-3">
                    <label for="fechaInicio" class="form-label">Desde</label>
                    <input type="date" id="fechaInicio" class="form-control" value="{{ now()->subDays(60)->toDateString() }}">
                </div>
                <div class="col-sm-4 col-lg-3">
                    <label for="fechaFin" class="form-label">Hasta</label>
                    <input type="date" id="fechaFin" class="form-control" value="{{ now()->toDateString() }}">
                </div>
                <div class="col-sm-4 col-lg-6 text-sm-end">
                    <span class="text-body-secondary d-block small">Total de comisión (solo entregadas)</span>
                    <span id="total" class="fs-4 fw-bold">$0.00</span>
                </div>
            </form>
            <table id="table1" class="table table-striped w-100">
                <thead>
                    <tr>
                        <th>Entrega</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Cliente</th>
                        <th>Comisión</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(function() {
            const pesos = new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' });
            const marca = (id, finDelDia) => {
                const [a, m, d] = $(id).val().split('-').map(Number);
                return new Date(a, m - 1, d, finDelDia ? 23 : 0, finDelDia ? 59 : 0).getTime();
            };

            const tabla = $('#table1').DataTable({
                ajax: {
                    url: "{{ route('comisionesRepartidor.index') }}",
                    data: d => Object.assign(d, { fechaInicio: marca('#fechaInicio'), fechaFin: marca('#fechaFin', true) }),
                    dataSrc: respuesta => {
                        $('#total').text(pesos.format(Number(respuesta.totalCostoEntrega) || 0));
                        return respuesta.data;
                    },
                },
                columns: [
                    { data: 'id' },
                    { data: 'status' },
                    { data: 'fecha' },
                    { data: 'hora' },
                    { data: 'socio' },
                    { data: 'costo_entrega', className: 'text-end', render: v => pesos.format(Number(v) || 0) },
                ],
                createdRow: (fila, datos) => {
                    if (datos.status === 'Entregado') {
                        $(fila).addClass('table-success');
                    }
                },
                fixedColumns: false,
                order: [],
                pageLength: 25,
            });

            $('#fechaInicio, #fechaFin').on('change', () => tabla.ajax.reload());
        });
    </script>
@stop
