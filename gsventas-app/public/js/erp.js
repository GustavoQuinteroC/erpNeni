/* Configuración común de erpNeni: tablas, búsquedas y avisos. */
(function ($) {
    'use strict';

    // Traducción oficial de DataTables 2.3.8 (es-ES), incluida aquí para no pedirla a otro dominio.
    var IDIOMA_TABLAS = {"aria":{"orderable":"Activar para ordenar","orderableRemove":"Activar para quitar ordenación","orderableReverse":"Activar para ordenar de forma inversa","paginate":{"first":"Primero","last":"Último","next":"Siguiente","previous":"Anterior"}},"autoFill":{"cancel":"Cancelar","fill":"Rellene todas las celdas con <i>%d</i>","fillHorizontal":"Rellenar celdas horizontalmente","fillVertical":"Rellenar celdas verticalmente","info":""},"buttons":{"collection":"Colección","colvis":"Visibilidad","colvisRestore":"Restaurar visibilidad","copy":"Copiar","copyKeys":"Presione ctrl o u2318 + C para copiar los datos de la tabla al portapapeles del sistema. <br /> <br /> Para cancelar, haga clic en este mensaje o presione escape.","copySuccess":{"_":"Copiadas %ds filas al portapapeles","1":"Copiada 1 fila al portapapeles"},"copyTitle":"Copiar al portapapeles","createState":"Crear Estado","csv":"CSV","excel":"Excel","pageLength":{"_":"Mostrar %d filas","-1":"Mostrar todas las filas","1":"Mostrar 1 fila"},"pdf":"PDF","print":"Imprimir","removeAllStates":"Remover Estados","removeState":"Remover","renameState":"Cambiar nombre","savedStates":"Estados Guardados","stateRestore":"Estado %d","updateState":"Actualizar"},"columnControl":{"buttons":{"searchClear":"Borrar búsqueda"},"colVis":"Visibilidad","colVisDropdown":"Desplegable visibilidad","dropdown":"Desplegable","list":{"all":"Añadir","empty":"Vacío","none":"Ninguno","search":"Buscar.."},"orderAddAsc":"Añadir a ordenación ascendente","orderAddDesc":"Añadir a ordenación descencente","orderAsc":"Ordenar ascendentemente","orderClear":"Borrar ordenación","orderDesc":"Ordenar descendentemente","orderRemove":"Borrar de ordenación","reorder":"Reordenar","reorderLeft":"Mover a la izquierda","reorderRight":"Mover a la derecha","search":{"datetime":{"empty":"Vacío","equal":"Igual a","greater":"Mayor que","less":"Menor que","notEmpty":"No vacío","notEqual":"Diferente de"},"number":{"empty":"Vacío","equal":"Igual a","greater":"Mayor que","greaterOrEqual":"Mayor o igual a","less":"Menor que","lessOrEqual":"Menor o igual a","notEmpty":"No vacío","notEqual":"Diferente de"},"text":{"contains":"Contiene","empty":"Vacío","ends":"Finaliza con","equal":"Igual a","notContains":"no contiene","notEmpty":"No vacío","notEqual":"Diferente de","starts":"Empieza con"}},"searchClear":"Borrar búsqueda","searchDropdown":"Buscar"},"datetime":{"amPm":{"0":"AM","1":"PM"},"hours":"Horas","minutes":"Minutos","months":{"0":"Enero","1":"Febrero","10":"Noviembre","11":"Diciembre","2":"Marzo","3":"Abril","4":"Mayo","5":"Junio","6":"Julio","7":"Agosto","8":"Septiembre","9":"Octubre"},"next":"Próximo","previous":"Anterior","seconds":"Segundos","unknown":"-","weekdays":{"0":"Dom","1":"Lun","2":"Mar","3":"Mié","4":"Jue","5":"Vie","6":"Sáb"}},"decimal":"","editor":{"close":"Cerrar","create":{"button":"Nuevo","submit":"Crear","title":"Crear Nuevo Registro"},"edit":{"button":"Editar","submit":"Actualizar","title":"Editar Registro"},"error":{"system":"Ha ocurrido un error en el sistema (<a target=\"\\\" rel=\"\\ nofollow\" href=\"\\\">Más información&lt;\\/a&gt;).</a>"},"multi":{"info":"Los elementos seleccionados contienen diferentes valores para este registro. Para editar y establecer todos los elementos de este registro con el mismo valor, haga clic o pulse aquí, de lo contrario conservarán sus valores individuales.","noMulti":"Este registro puede ser editado individualmente, pero no como parte de un grupo.","restore":"Deshacer Cambios","title":"Múltiples Valores"},"remove":{"button":"Eliminar","confirm":{"_":"¿Está seguro de que desea eliminar %d filas?","1":"¿Está seguro de que desea eliminar 1 fila?"},"submit":"Eliminar","title":"Eliminar Registro"}},"emptyTable":"Ningún dato disponible en esta tabla","info":"Mostrando _START_ a _END_ de _TOTAL_ registros","infoEmpty":"Mostrando registros del 0 al 0 de un total de 0 registros","infoFiltered":"(filtrado de un total de _MAX_ registros)","infoPostFix":"","infoThousands":".","lengthLabels":{"-1":"Todas"},"lengthMenu":"Mostrar _MENU_ registros","loadingRecords":"Cargando...","orderClear":"Limpiar ordenación de toda la tabla","processing":"Procesando...","search":"Buscar:","searchBuilder":{"add":"Añadir condición","button":{"_":"Constructor de búsqueda (%d)","0":"Constructor de búsqueda"},"clearAll":"Borrar todo","condition":"Condición","conditions":{"array":{"contains":"Contiene","empty":"Vacío","equals":"Igual","not":"Diferente de","notEmpty":"No Vacío","without":"Sin"},"date":{"after":"Después","before":"Antes","between":"Entre","empty":"Vacío","equals":"Igual a","not":"Diferente de","notBetween":"No entre","notEmpty":"No Vacío"},"number":{"between":"Entre","empty":"Vacío","equals":"Igual a","gt":"Mayor a","gte":"Mayor o igual a","lt":"Menor que","lte":"Menor o igual que","not":"Diferente de","notBetween":"No entre","notEmpty":"No vacío"},"string":{"contains":"Contiene","empty":"Vacío","endsWith":"Termina en","equals":"Igual a","not":"Diferente de","notContains":"No Contiene","notEmpty":"No Vacío","notEndsWith":"No termina con","notStartsWith":"No empieza con","startsWith":"Empieza con"}},"data":"Data","deleteTitle":"Eliminar regla de filtrado","leftTitle":"Criterios anulados","logicAnd":"Y","logicOr":"O","rightTitle":"Criterios de sangría","search":"Buscar","title":{"_":"Constructor de búsqueda (%d)","0":"Constructor de búsqueda"},"value":"Valor"},"searchPanes":{"clearMessage":"Borrar todo","collapse":{"_":"Paneles de búsqueda (%d)","0":"Paneles de búsqueda"},"collapseMessage":"Colapsar Todo","count":"{total}","countFiltered":"{shown} ({total})","emptyMessage":"vacío","emptyPanes":"Sin paneles de búsqueda","loadMessage":"Cargando paneles de búsqueda","showMessage":"Mostrar Todo","title":"Filtros Activos - %d"},"searchPlaceholder":"","select":{"cells":{"_":"%d celdas seleccionadas","0":"","1":"1 celda seleccionada"},"columns":{"_":"%d columnas seleccionadas","0":"","1":"1 columna seleccionada"},"rows":{"_":"%d filas seleccionadas","0":"","1":"1 fila seleccionada"}},"stateRestore":{"creationModal":{"button":"Crear","columns":{"search":"Búsqueda de Columna","visible":"Visibilidad de Columna"},"name":"Nombre:","order":"Clasificación","paging":"Paginación","scroller":"Posición de desplazamiento","search":"Búsqueda","searchBuilder":"Búsqueda avanzada","select":"Seleccionar","title":"Crear Nuevo Estado","toggleLabel":"Incluir:"},"duplicateError":"Ya existe un Estado con este nombre.","emptyError":"El nombre no puede estar vacío.","emptyStates":"No hay Estados guardados","removeConfirm":"¿Seguro que quiere eliminar %s?","removeError":"Error al eliminar el Estado","removeJoiner":"y","removeSubmit":"Eliminar","removeTitle":"Remover Estado","renameButton":"Cambiar Nombre","renameLabel":"Nuevo nombre para %s:","renameTitle":"Cambiar Nombre Estado"},"thousands":".","zeroRecords":"No se encontraron resultados"};

    // DataTables 2: español, servidor, texto en varias líneas y la columna de Acciones siempre a la vista.
    if ($.fn.dataTable) {
        $.extend(true, $.fn.dataTable.defaults, {
            language: IDIOMA_TABLAS,
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
