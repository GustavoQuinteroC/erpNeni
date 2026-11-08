# ERP Neni

ERP de ventas, entregas e inventario para una tienda en línea que entrega en estaciones del Tren Ligero y del Macrobús de Guadalajara. Hecho con Laravel 13, AdminLTE y MariaDB, con manifiestos para Kubernetes.

**En vivo:** https://neni.gustavoquintero.dev/ (entra con la cuenta demo de solo lectura que aparece en la pantalla de acceso).

## Qué hace

- **Ventas** con captura del cliente, productos, forma de pago y la entrega en un mismo paso. Cada venta descuenta existencia y genera su folio.
- **Entregas** por estado (por contactar, contactado, confirmado, entregado o cancelado), con listas de hoy y de mañana y botones para llamar o escribir por WhatsApp al cliente.
- **Generador de rutas** con el mapa de las entregas del día.
- **Compras:** proveedores y recepciones de mercancía que suman existencia.
- **Almacenes e inventario:** existencias por almacén y kardex de movimientos de entrada y salida.
- **Comisiones** de vendedores y repartidores por rango de fechas.
- **Tablero** con ventas por usuario, productos más vendidos del mes y montos de los últimos seis meses.

## Decisiones de diseño

- **Todo pide sesión.** Solo la pantalla de acceso es pública; no hay registro abierto ni recuperación de contraseña por correo.
- **Cuenta demo de solo lectura:** un middleware deja consultar todo, pero rechaza cualquier alta, cambio o borrado de esa cuenta.
- **Ventas y recepciones en una transacción:** la venta, su entrega, el movimiento de almacén y el ajuste de existencia se guardan juntos o no se guarda nada.
- **Datos de ejemplo ficticios:** la semilla crea clientes, productos y operaciones inventados de los últimos cinco meses.

## Instalación

Requiere PHP 8.3 o mayor con `pdo_mysql` y `mbstring`, y MariaDB 10.6 o mayor (el tablero usa funciones de fecha de MySQL/MariaDB).

```bash
cd gsventas-app
composer install --no-dev --optimize-autoloader
cp .env.example .env   # llena DB_*
php artisan key:generate
php artisan migrate --force
php artisan db:seed --force                                      # cuenta demo y datos de ejemplo (opcional)
php artisan erp:usuario tu@correo.mx "Tu nombre" 3312345678      # administrador; pide la contraseña sin mostrarla
```

La raíz pública es `gsventas-app/public/`. Cada versión etiquetada (`v*`) publica en Releases un zip con `vendor/` incluido, listo para descomprimir en el servidor.

## Kubernetes

`k8s/` trae los manifiestos con los que se desplegó primero: MariaDB con volumen persistente, la app con un `initContainer` que clona `gsventas-app/` del repo, y su servicio. `web/Dockerfile` arma la imagen con Apache y PHP 8.5.

```bash
kubectl apply -f k8s/db-deployment.yaml -f k8s/db-service.yaml
kubectl apply -f k8s/web-deployment.yaml -f k8s/web-service.yaml
```

## Pruebas

GitHub Actions corre PHPUnit en PHP 8.4 y 8.5 contra MariaDB 12 en cada push: acceso a cada pantalla con y sin sesión, listados de DataTables, la cuenta demo de solo lectura, ventas y recepciones con su efecto en la existencia, y el comando para crear administradores.

## Licencia

MIT. Hecho por [Gustavo Quintero](https://gustavoquintero.dev).
