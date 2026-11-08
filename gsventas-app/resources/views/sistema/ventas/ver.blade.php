@extends('adminlte::page')

@section('title', 'Principal')

@section('content_header')
    <h1 class="m-0">{{ $socio->name }}</h1>
@stop

@section('content')
    @include('partials.aviso')
    <section class="content">
        <p>Ingrese la informacion de la venta</p>
        <div class="card">
            @if (session()->has('message') && session('message') == 'ok')
                <x-adminlte-alert theme="success" title="Guardado">
                    La venta se ha guardado de manera exitosa!
                </x-adminlte-alert>
            @endif
            <div class="card-body">
                <form action="{{ route('ventas.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Datos de la venta:</h4>
                            <!-- Columna izquierda -->
                            <x-adminlte-input name="nombre_cliente" id="nombre_cliente" value="{{ $socio->name }}"
                                readonly>
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="bi bi-person"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                            <x-adminlte-input type="tel" name="telefono" value="{{ $socio->telefono }}" readonly>
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="bi bi-telephone"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                            <x-adminlte-input name="almacen" value="{{ $almacen->name }}" readonly>
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="bi bi-house-door"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                            <x-adminlte-input name="forma_pago" value="{{ $venta->forma_pago }}" readonly>
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="bi bi-wallet2"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                            <x-adminlte-input name="cuenta_pago" value="{{ $venta->cuenta_pago }}" readonly>
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="bi bi-credit-card"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                        </div>
                        <div class="col-md-6">
                            <!-- Columna derecha -->
                            <h4>Datos de la entrega:</h4>
                            <x-adminlte-input name="nombre_punto" id="nombre_punto" value="{{ $punto_entrega->name }}"
                                readonly>
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="bi bi-geo-alt"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                            <x-adminlte-input name="nombre_usuario" id="nombre_usuario" value="{{ $usuario->name }}"
                                readonly>
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="bi bi-person"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                            <x-adminlte-input name="fecha" type="date" value="{{ $entrega->fecha }}" readonly>
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="bi bi-calendar-check"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                            <x-adminlte-input name="hora" type="time" value="{{ $entrega->hora }}" readonly>
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="bi bi-clock"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                            <x-adminlte-input name="notas_entrega" id="notas_entrega" type="text"
                                value="{{ $venta->notas }}" readonly>
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="bi bi-sticky"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>

                            <!-- Campo para el Costo por Entrega -->
                            <x-adminlte-input name="costo_entrega" id="costo_entrega" type="number" step="0.01"
                                value="{{ $entrega->costo_entrega }}" readonly>
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="bi bi-currency-dollar"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <h5 class="text-center">Productos</h5>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>catalogo</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Importe</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productos as $producto)
                                    <tr>
                                        <td>{{ $producto->id }}</td>
                                        <td>{{ $producto->catalogo }}</td>
                                        <td>{{ $producto->preciou }}</td>
                                        <td>{{ $producto->cantidad }}</td>
                                        <td>{{ $producto->preciou * $producto->cantidad }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-10"></div>
                        <div class="col-md-2">
                            <tfoot>
                                <tr>
                                    <td colspan="5"></td>
                                    <td><strong>Total</strong></td>
                                    <td id="total-importe"><strong>{{ $venta->total }}</strong></td>
                                    <!-- ID para actualizar el total de importe -->
                                </tr>
                            </tfoot>
                        </div>
                    </div>
                    <!-- Contenedor del botonera -->
                    <div class="row mt-3">
                        <div class="col-md-12 d-flex justify-content-end">
                            <!--<x-adminlte-button type="submit" label="Guardar" theme="primary" icon="bi bi-floppy" />-->
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@stop
