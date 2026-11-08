@extends('adminlte::page')

@section('title', 'Tablero')
@section('plugins.ApexCharts', true)

@section('content_header')
    <h1 class="m-0">Tablero</h1>
@stop

@php
    $pesos = fn ($valor) => '$' . number_format((float) $valor, 2);
    $nombresMes = ['', 'ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic'];
@endphp

@section('content')
    @include('partials.aviso')
    <div class="row">
        <div class="col-sm-6 col-xl-3">
            <x-adminlte-small-box theme="primary" icon="bi bi-box-seam"
                :title="$existenciaProductoMayorPorcentaje->producto ?? 'Sin datos'"
                :text="'Más vendido del mes · existencia ' . ($existenciaProductoMayorPorcentaje->total_existencia ?? 0)"
                :url="route('inventarios.index')" url-text="Ver inventario" />
        </div>
        <div class="col-sm-6 col-xl-3">
            <x-adminlte-small-box theme="success" icon="bi bi-bag-check"
                :title="$totalVentas" text="Ventas entregadas en 30 días"
                :url="route('ventas.index')" url-text="Ver ventas" />
        </div>
        <div class="col-sm-6 col-xl-3">
            <x-adminlte-small-box theme="info" icon="bi bi-person-badge"
                :title="$pesos($comisionesVendedor)" text="Comisiones de vendedores, 30 días"
                :url="route('comisionesVendedor.index')" url-text="Ver comisiones" />
        </div>
        <div class="col-sm-6 col-xl-3">
            <x-adminlte-small-box theme="warning" icon="bi bi-truck"
                :title="$pesos($comisionesRepartidor)" text="Comisiones de repartidores, 30 días"
                :url="route('comisionesRepartidor.index')" url-text="Ver comisiones" />
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-xl-3">
            <x-adminlte-card title="Productos vendidos, 30 días" icon="bi bi-pie-chart" collapsible>
                @if ($productosVendidosEnElMes->isEmpty())
                    <p class="text-body-secondary mb-0">Sin ventas en los últimos 30 días.</p>
                @else
                    <div id="graficaProductos"></div>
                @endif
            </x-adminlte-card>
        </div>
        <div class="col-lg-6 col-xl-3">
            <x-adminlte-card title="Ventas por vendedor" icon="bi bi-people" collapsible>
                @if ($ventasPorUsuario->sum('ventas_pesos') == 0)
                    <p class="text-body-secondary mb-0">Sin ventas registradas.</p>
                @else
                    <div id="graficaVendedores"></div>
                @endif
            </x-adminlte-card>
        </div>
        <div class="col-xl-6">
            <x-adminlte-card title="Monto vendido por mes" icon="bi bi-graph-up" collapsible>
                @if ($montosVendidosPorMes->isEmpty())
                    <p class="text-body-secondary mb-0">Sin ventas en los últimos seis meses.</p>
                @else
                    <div id="graficaMeses"></div>
                @endif
            </x-adminlte-card>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(function() {
            const pesos = new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN', maximumFractionDigits: 0 });
            const oscuro = () => document.documentElement.getAttribute('data-bs-theme') === 'dark';
            const base = () => ({
                chart: { fontFamily: 'inherit', background: 'transparent', toolbar: { show: false } },
                theme: { mode: oscuro() ? 'dark' : 'light' },
                legend: { position: 'bottom' },
                dataLabels: { enabled: false },
            });
            const graficas = [];
            const pintar = (id, opciones) => {
                const nodo = document.getElementById(id);
                if (!nodo) {
                    return;
                }
                const grafica = new ApexCharts(nodo, $.extend(true, base(), opciones));
                grafica.render();
                graficas.push(grafica);
            };

            pintar('graficaProductos', {
                chart: { type: 'donut', height: 280 },
                labels: @json($productosVendidosEnElMes->pluck('producto')),
                series: @json($productosVendidosEnElMes->pluck('total_vendido')->map(fn ($v) => (int) $v)),
                tooltip: { y: { formatter: v => v + ' piezas' } },
            });

            pintar('graficaVendedores', {
                chart: { type: 'donut', height: 280 },
                labels: @json($ventasPorUsuario->where('ventas_pesos', '>', 0)->pluck('nombre_usuario')->values()),
                series: @json($ventasPorUsuario->where('ventas_pesos', '>', 0)->pluck('ventas_pesos')->map(fn ($v) => (float) $v)->values()),
                tooltip: { y: { formatter: v => pesos.format(v) } },
            });

            pintar('graficaMeses', {
                chart: { type: 'area', height: 280 },
                series: [{
                    name: 'Vendido',
                    data: @json($montosVendidosPorMes->map(fn ($m) => (float) $m->monto_vendido)),
                }],
                xaxis: {
                    categories: @json($montosVendidosPorMes->map(fn ($m) => $nombresMes[(int) $m->mes] . ' ' . $m->{'año'})),
                },
                yaxis: { labels: { formatter: v => pesos.format(v) } },
                stroke: { curve: 'smooth', width: 2 },
                legend: { show: false },
            });

            // Las gráficas cambian de colores cuando cambia el tema claro u oscuro.
            new MutationObserver(() => graficas.forEach(g => g.updateOptions({ theme: { mode: oscuro() ? 'dark' : 'light' } })))
                .observe(document.documentElement, { attributes: true, attributeFilter: ['data-bs-theme'] });
        });
    </script>
@stop
