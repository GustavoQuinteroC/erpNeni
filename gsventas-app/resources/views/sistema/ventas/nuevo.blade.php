@extends('adminlte::page')

@section('title', 'Principal')

@section('content_header')
    <h1 class="m-0">Registro de venta</h1>
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
                            <input type="hidden" name="idsocio" id="idsocio" value="">
                            <input type="hidden" name="idusuario" id="idusuario" value="">
                            <input type="hidden" name="productos_seleccionados" id="productos_seleccionados"value="">
                            <input type="hidden" name="total_hidden" id="total_hidden" value="">
                            <input type="hidden" name="idpunto_entrega" id="idpunto_entrega" value="">
                            <!-- Columna izquierda -->
                            <x-adminlte-input name="nombre_cliente" id="nombre_cliente"
                                placeholder="Buscar cliente por nombre / nombre del cliente">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="bi bi-person"></i>
                                    </div>
                                </x-slot>
                                <x-slot name="appendSlot">
                                    <div class="input-group-text">
                                        <i class="bi bi-search"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                            <x-adminlte-input type="tel" name="telefono" placeholder="Telefono (10 Digitos)">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="bi bi-telephone"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                            <x-adminlte-select2 name="idalmacen" label-class="text-primary" data-placeholder="Almacen...">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="bi bi-house-door"></i>
                                    </div>
                                </x-slot>
                                <x-adminlte-options :options="['' => 'Almacen...'] + $almacenes->pluck('name', 'id')->toArray()" selected="" />
                            </x-adminlte-select2>
                            <x-adminlte-select2 name="forma_pago" label-class="text-body-secondary"
                                data-placeholder="Forma de pago...">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="bi bi-wallet2"></i>
                                    </div>
                                </x-slot>
                                <x-adminlte-options :options="[
                                    '' => 'Forma de pago...',
                                    'SPEI' => 'SPEI',
                                    'Efectivo' => 'Efectivo',
                                    'Tranferencia' => 'Tranferencia',
                                    'Deposito bancario' => 'Deposito bancario',
                                    'Pago en plataforma' => 'Pago en plataforma',
                                ]" />
                            </x-adminlte-select2>
                            <x-adminlte-input name="cuenta_pago" placeholder="Cuenta de pago">
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
                            <x-adminlte-input name="nombre_punto" id="nombre_punto"
                                placeholder="Buscar punto de entrega por nombre">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="bi bi-geo-alt"></i>
                                    </div>
                                </x-slot>
                                <x-slot name="appendSlot">
                                    <div class="input-group-text">
                                        <i class="bi bi-search"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                            <x-adminlte-input name="nombre_usuario" id="nombre_usuario"
                                placeholder="Buscar por nombre al usuario asignado">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="bi bi-person"></i>
                                    </div>
                                </x-slot>
                                <x-slot name="appendSlot">
                                    <div class="input-group-text">
                                        <i class="bi bi-search"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                            <x-adminlte-input name="fecha" placeholder="Fecha de entrega" type="date"
                                value="{{ now()->format('Y-m-d') }}">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="bi bi-calendar-check"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                            <x-adminlte-input name="hora" placeholder="Hora de entrega" type="time"
                                value="{{ now()->format('H:i') }}">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="bi bi-clock"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                            <x-adminlte-input name="notas_entrega" id="notas_entrega" placeholder="Notas de Entrega"
                                type="text">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="bi bi-sticky"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>

                            <!-- Campo para el Costo por Entrega -->
                            <x-adminlte-input name="costo_entrega" id="costo_entrega" placeholder="Costo por Entrega"
                                type="number" step="0.01">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="bi bi-currency-dollar"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                        </div>
                    </div>
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Productos</h4>
                            </div>
                            <div class="col-md-6 text-end">
                                <button id="btnAgregarProductos" type="button" class="btn btn-primary">Agregar
                                    productos</button>
                            </div>
                        </div>
                    </div>
                    <x-adminlte-datatable id="table1" :heads="['ID', 'Catálogo', 'Precio', 'Cantidad', 'Importe', 'Acciones']" :config="[
                        'paging' => false,
                        'searching' => false,
                        'info' => false,
                        'ordering' => false,
                        'columnDefs' => [
                            ['width' => '5%', 'targets' => 0],
                            ['width' => '30%', 'targets' => 1],
                            ['width' => '15%', 'targets' => 3],
                            ['width' => '20%', 'targets' => 4],
                            ['width' => '20%', 'targets' => 5],
                            ['width' => '10%', 'targets' => 6],
                        ],
                    ]">
                        <tfoot>
                            <tr>
                                <td colspan="4"></td>
                                <td><strong>Total</strong></td>
                                <td id="total-importe"><strong>0.00</strong></td>
                                <!-- ID para actualizar el total de importe -->
                            </tr>
                        </tfoot>
                    </x-adminlte-datatable>

                    <!-- Contenedor del botonera -->
                    <div class="row mt-3">
                        <div class="col-md-12 d-flex justify-content-end">
                            <x-adminlte-button type="submit" label="Guardar" theme="primary" icon="bi bi-floppy" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Modal para agregar productos -->
        <x-adminlte-modal id="modalProductos" title="Lista de productos" size="lg" theme="primary"
            icon="bi bi-cart">
            <div class="modal-body">
                <table id="tablaProductos" class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th style="text-align: center;">Agregar</th> {{-- Estilo centrado --}}
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <x-slot name="footerSlot">
                <x-adminlte-button class="mr-auto" theme="danger" label="Cancelar" data-bs-dismiss="modal" />
                <x-adminlte-button theme="success" label="Aceptar" />
            </x-slot>
        </x-adminlte-modal>
        <!-- Modal para editar productos -->
        <x-adminlte-modal id="modalEditarProducto" title="Editar producto" size="md" theme="primary"
            icon="bi bi-pencil-square">
            <div class="modal-body">
                <input type="hidden" id="edit-product-id">
                <p><strong>Catálogo:</strong> <span id="edit-product-catalog"></span></p>
                <x-adminlte-input name="edit-product-precio" id="edit-product-precio" label="Precio"
                    placeholder="Ingrese el precio del producto" type="number" step="any" />
                <x-adminlte-input name="edit-product-quantity" id="edit-product-quantity" label="Cantidad"
                    placeholder="Ingrese la cantidad del producto" type="number" />
            </div>
            <x-slot name="footerSlot">
                <x-adminlte-button class="mr-auto" theme="danger" label="Cancelar" data-bs-dismiss="modal" />
                <x-adminlte-button class="editar-producto" theme="success" label="Guardar" />
            </x-slot>
        </x-adminlte-modal>



    </section>
@stop

@section('js')

    <script>
        $(document).ready(function() {
            var productos = @json($productos);
            var idsProductos = [];

            $('#btnAgregarProductos').on('click', function() {
                var idalmacen = $('#idalmacen').val();
                if (!idalmacen) {
                    Swal.fire({
                        title: "¡Error!",
                        text: "Por favor, seleccione un almacén antes de agregar productos.",
                        icon: "error"
                    });
                } else {
                    $('#modalProductos').modal('show');
                    $.get('{{ route('productos.getProductsForAlmacen') }}', {
                        idalmacen: idalmacen
                    }, function(data) {
                        $('#tablaProductos tbody').empty();
                        data.forEach(function(producto) {
                            $('#tablaProductos tbody').append('<tr><td>' + producto.id +
                                '</td><td>' + producto.catalogo +
                                '</td><td style="text-align: center;"><input type="checkbox" class="producto-checkbox" value="' +
                                producto.id +
                                '" style="margin-left:auto;margin-right:auto;display:block;" /></td></tr>'
                            );
                        });
                    });
                }
            });


            $('#modalProductos button.btn-success').on('click', function() {
                var productosSeleccionados = obtenerProductosSeleccionados();

                $.ajax({
                    url: "{{ route('productos.getInfo') }}",
                    type: "POST",
                    data: {
                        productos: productosSeleccionados,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        response.forEach(function(producto) {
                            producto.cantidad = 1;
                            productos.push(producto);
                            idsProductos.push(producto.id);
                        });
                        actualizarTabla(productos);
                        $('#modalProductos').modal('hide');
                    },
                    error: function(xhr, status, error) {
                        // Manejar el error
                    }
                });
            });

            $('#modalEditarProducto .editar-producto').on('click', function() {
                var idProducto = $('#edit-product-id').val();
                var precio = $('#edit-product-precio').val();
                var cantidad = $('#edit-product-quantity').val();
                var productoIndex = productos.findIndex(function(prod) {
                    return prod.id === parseInt(idProducto);
                });

                if (productoIndex !== -1) {
                    productos[productoIndex].precio = parseFloat(precio).toFixed(2);
                    productos[productoIndex].cantidad = parseInt(cantidad);
                }

                actualizarTabla(productos);
                $('#modalEditarProducto').modal('hide');
            });

            $('#costo_entrega').on('input', function() {
                actualizarTabla(productos);
            });

            function actualizarTabla(productos) {
                var tablaProductos = $('#table1 tbody');
                var totalImporte = 0;
                var costoEntrega = parseFloat($('#costo_entrega').val()) || 0;
                tablaProductos.empty();
                var productosSeleccionados = [];

                productos.forEach(function(producto) {
                    var importe = parseFloat(producto.precio) * parseInt(producto.cantidad);
                    totalImporte += importe;

                    var fila = $('<tr>');
                    fila.append('<td>' + producto.id + '</td>');
                    fila.append('<td>' + producto.catalogo + '</td>');
                    fila.append('<td>' + producto.precio + '</td>');
                    fila.append('<td>' + producto.cantidad + '</td>');
                    fila.append('<td>' + importe.toFixed(2) + '</td>');
                    var columnaIconos = $('<td>').addClass('text-center');
                    var iconoEliminar = $('<i>').addClass('bi bi-trash3 text-danger me-2').attr('title',
                        'Eliminar').css('cursor', 'pointer').click(function() {
                        eliminarProducto(producto.id);
                    });
                    var iconoEditar = $('<i>').addClass('bi bi-pencil-square text-primary').attr('title', 'Editar')
                        .css('cursor', 'pointer').click(function() {
                            editarProducto(producto.id);
                        });
                    columnaIconos.append(iconoEliminar, iconoEditar);
                    fila.append(columnaIconos);
                    tablaProductos.append(fila);

                    productosSeleccionados.push({
                        id: producto.id,
                        precio: producto.precio,
                        cantidad: producto.cantidad
                    });
                });

                $('#productos_seleccionados').val(JSON.stringify(productosSeleccionados));
                totalImporte += costoEntrega;
                $('#total-importe').text(totalImporte.toFixed(2));
                $('#total_hidden').val(totalImporte.toFixed(2));
            }

            function editarProducto(idProducto) {
                var producto = productos.find(function(prod) {
                    return prod.id === idProducto;
                });

                $('#edit-product-id').val(producto.id);
                $('#edit-product-catalog').text(producto.catalogo);
                $('#edit-product-precio').val(producto.precio);
                $('#edit-product-quantity').val(producto.cantidad);
                $('#modalEditarProducto').modal('show');
            }

            function eliminarProducto(idProducto) {
                var indice = productos.findIndex(function(prod) {
                    return prod.id === idProducto;
                });
                if (indice !== -1) {
                    productos.splice(indice, 1);
                    actualizarTabla(productos);
                }
            }

            function obtenerProductosSeleccionados() {
                return $('.producto-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();
            }

            $('#modalProductos').on('hidden.bs.modal', function(e) {
                $('.producto-checkbox').prop('checked', false);
            });





            // Autocompletado para clientes
            $('#nombre_usuario').autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('usuarios.buscar') }}",
                        type: "GET",
                        dataType: "json",
                        data: {
                            search: request.term
                        },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                select: function(event, ui) {
                    $('#idusuario').val(ui.item.id);
                    $('#nombre_usuario').val(ui.item.label);
                    return false;
                }
            });


            // Autocompletado para clientes
            $('#nombre_cliente').autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('clientes.buscar') }}",
                        type: "GET",
                        dataType: "json",
                        data: {
                            search: request.term
                        },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                select: function(event, ui) {
                    $('#idsocio').val(ui.item.id);
                    $('#nombre_cliente').val(ui.item.label);
                    $('#telefono').val(ui.item.telefono);
                    $('#sexo').val(ui.item.sexo);
                    return false;
                }
            });

            // Autocompletado para puntos de entrega
            $('#nombre_punto').autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('puntos_entregas.buscar') }}",
                        type: "GET",
                        dataType: "json",
                        data: {
                            search: request.term
                        },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                select: function(event, ui) {
                    $('#nombre_punto').val(ui.item.label);
                    $('#idpunto_entrega').val(ui.item.id);
                    return false;
                }
            });
        });
    </script>
@stop

