/* Configuración común de erpNeni: tablas, búsquedas y avisos. */
(function ($) {
    'use strict';

    // DataTables 2: español, servidor, texto en varias líneas y la columna de Acciones siempre a la vista.
    if ($.fn.dataTable) {
        $.extend(true, $.fn.dataTable.defaults, {
            language: { url: '//cdn.datatables.net/plug-ins/2.3.8/i18n/es-ES.json' },
            processing: true,
            autoWidth: false,
            scrollX: true,
            fixedColumns: { start: 0, end: 1 },
        });
    }

    // Select2 en español y a lo ancho de su contenedor.
    if ($.fn.select2) {
        $.fn.select2.defaults.set('language', 'es');
        $.fn.select2.defaults.set('width', '100%');
    }

    // SweetAlert2 sigue el tema claro u oscuro del sistema.
    if (window.Swal) {
        window.Swal = window.Swal.mixin({ theme: 'auto' });
    }

    // Aviso corto en la esquina, para guardados y para la demo de solo lectura.
    window.avisoErp = function (icono, texto) {
        if (!window.Swal) {
            return;
        }
        window.Swal.fire({ toast: true, position: 'top-end', timer: 3500, timerProgressBar: true,
            showConfirmButton: false, icon: icono, title: texto });
    };

    // Autocompletado para buscar clientes, proveedores, usuarios y puntos de entrega mientras se escribe.
    // Acepta las opciones que usaban las vistas con jQuery UI: source(request, response) y select(event, ui).
    $.fn.autocomplete = function (opciones) {
        return this.each(function () {
            var $campo = $(this).attr('autocomplete', 'off');
            var $lista = $('<ul class="dropdown-menu shadow erp-sugerencias" role="listbox"></ul>');
            var espera = null;
            var activo = -1;
            var elementos = [];

            // La lista va después del grupo del campo, para no romper los bordes del input-group.
            var $grupo = $campo.closest('.input-group');
            $grupo = $grupo.length ? $grupo : $campo;
            $grupo.parent().css('position', 'relative');
            $grupo.after($lista);

            function cerrar() {
                $lista.removeClass('show').empty();
                activo = -1;
            }

            function marcar(indice) {
                activo = indice;
                $lista.find('.dropdown-item').removeClass('active').eq(indice).addClass('active');
            }

            function elegir(indice) {
                var item = elementos[indice];
                if (!item) {
                    return;
                }
                cerrar();
                if (opciones.select) {
                    opciones.select($.Event('autocompleteselect'), { item: item });
                }
            }

            function pintar(datos) {
                elementos = datos || [];
                $lista.empty();
                if (!elementos.length || !$campo.is(':focus')) {
                    cerrar();
                    return;
                }
                elementos.forEach(function (item, indice) {
                    $('<li><button type="button" class="dropdown-item"></button></li>')
                        .find('button').text(item.label).on('mousedown', function (e) {
                            e.preventDefault();
                            elegir(indice);
                        }).end().appendTo($lista);
                });
                $lista.css({ position: 'absolute', top: $grupo.position().top + $grupo.outerHeight(),
                    left: $grupo.position().left, width: $grupo.outerWidth() }).addClass('show');
            }

            $campo.on('input', function () {
                clearTimeout(espera);
                var termino = $campo.val().trim();
                if (termino.length < (opciones.minLength || 1)) {
                    cerrar();
                    return;
                }
                espera = setTimeout(function () {
                    opciones.source({ term: termino }, pintar);
                }, 250);
            }).on('keydown', function (e) {
                if (!$lista.hasClass('show')) {
                    return;
                }
                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    marcar(Math.min(activo + 1, elementos.length - 1));
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    marcar(Math.max(activo - 1, 0));
                } else if (e.key === 'Enter' && activo >= 0) {
                    e.preventDefault();
                    elegir(activo);
                } else if (e.key === 'Escape') {
                    cerrar();
                }
            }).on('blur', cerrar);
        });
    };

    // Las peticiones AJAX que el servidor rechaza muestran su mensaje (por ejemplo, la demo de solo lectura).
    $(document).ajaxError(function (evento, xhr) {
        if (xhr.status === 403 || xhr.status === 419) {
            var mensaje = (xhr.responseJSON && xhr.responseJSON.message) || 'No se pudo completar la acción.';
            window.avisoErp('warning', mensaje);
        }
    });
})(window.jQuery);
