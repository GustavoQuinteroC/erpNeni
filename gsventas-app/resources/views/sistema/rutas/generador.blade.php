@extends('adminlte::page')

@section('title', 'Generador de rutas')
@section('plugins.Leaflet', true)

@section('content_header')
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
        <h1 class="m-0">Rutas de hoy</h1>
        <button type="button" id="generar-ruta" class="btn btn-primary">
            <i class="bi bi-signpost-split me-1"></i> Trazar ruta
        </button>
    </div>
@stop

@section('content')
    @include('partials.aviso')
    <div class="card">
        <div class="card-body p-0">
            <div id="mapa" role="region" aria-label="Mapa de las entregas de hoy"></div>
        </div>
        <div class="card-footer small text-body-secondary">
            {{ $entregas->count() }} entregas para hoy. La ruta se calcula con OSRM sobre OpenStreetMap.
        </div>
    </div>
@stop

@section('js')
    <script>
        $(function() {
            const mapa = L.map('mapa').setView([20.6766, -103.3475], 12);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
                attribution: '&copy; colaboradores de OpenStreetMap',
            }).addTo(mapa);

            const texto = valor => $('<div>').text(valor ?? '').html();
            const pesos = new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' });
            const puntos = [];

            @json($entregas).forEach(entrega => {
                if (!entrega.latitud || !entrega.longitud) {
                    return;
                }
                const punto = [Number(entrega.latitud), Number(entrega.longitud)];
                L.marker(punto).addTo(mapa).bindPopup(
                    `<b>${texto(entrega.punto_name)}</b><br>` +
                    `Hora: ${texto((entrega.hora || '').slice(0, 5))}<br>` +
                    `Estado: ${texto(entrega.status)}<br>` +
                    `Cobrar: ${pesos.format(Number(entrega.cobrar_cliente) || 0)}`
                );
                puntos.push(punto);
            });

            if (puntos.length) {
                mapa.fitBounds(puntos, { padding: [40, 40], maxZoom: 15 });
            }

            let ruta = null;
            $('#generar-ruta').on('click', async function() {
                if (puntos.length < 2) {
                    avisoErp('info', 'Se necesitan al menos dos entregas con ubicación para trazar la ruta.');
                    return;
                }
                const coordenadas = puntos.map(([lat, lng]) => `${lng},${lat}`).join(';');
                try {
                    const respuesta = await fetch(`https://router.project-osrm.org/route/v1/driving/${coordenadas}?overview=full&geometries=geojson`);
                    const datos = await respuesta.json();
                    if (!datos.routes || !datos.routes.length) {
                        throw new Error('sin ruta');
                    }
                    if (ruta) {
                        ruta.remove();
                    }
                    ruta = L.geoJSON(datos.routes[0].geometry, { style: { color: '#0d6efd', weight: 5 } }).addTo(mapa);
                    mapa.fitBounds(ruta.getBounds(), { padding: [30, 30] });
                } catch (error) {
                    avisoErp('error', 'No se pudo calcular la ruta. Intenta de nuevo en un momento.');
                }
            });
        });
    </script>
@stop
