<?php

namespace Database\Seeders;

use App\Models\Almacen_producto;
use App\Models\Almacene;
use App\Models\Entrega;
use App\Models\Movimiento;
use App\Models\Movimientos_producto;
use App\Models\Producto;
use App\Models\Puntos_entrega;
use App\Models\Recepcione;
use App\Models\Recepciones_producto;
use App\Models\Role;
use App\Models\Socio;
use App\Models\User;
use App\Models\Venta;
use App\Models\Ventas_producto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Datos ficticios para la demo: una tienda en línea de relojes inteligentes en Guadalajara
 * que entrega en estaciones del Tren Ligero y del Macrobús.
 */
class DatabaseSeeder extends Seeder
{
    private const CLIENTES = [
        ['Ana Sofía Méndez', 'Mujer'], ['Luis Fernando Ortega', 'Hombre'], ['Carla Jiménez', 'Mujer'],
        ['Diego Armando Ruiz', 'Hombre'], ['Paola Navarro', 'Mujer'], ['Ricardo Salinas Vega', 'Hombre'],
        ['Fernanda Castillo', 'Mujer'], ['Héctor Galindo', 'Hombre'], ['Valeria Montes', 'Mujer'],
        ['Iván Cervantes', 'Hombre'], ['Daniela Ochoa', 'Mujer'], ['Óscar Villalobos', 'Hombre'],
        ['Mónica Aguilar', 'Mujer'], ['Jesús Arellano', 'Hombre'], ['Regina Sandoval', 'Mujer'],
    ];

    private const PUNTOS = [
        ['Juárez', 'Tren', '1', 20.67480000, -103.35500000],
        ['Mexicaltzingo', 'Tren', '1', 20.66760000, -103.35400000],
        ['Washington', 'Tren', '1', 20.66000000, -103.35300000],
        ['Plaza Universidad', 'Tren', '2', 20.67480000, -103.34800000],
        ['San Juan de Dios', 'Tren', '2', 20.67460000, -103.34000000],
        ['Guadalajara Centro', 'Tren', '3', 20.67670000, -103.34750000],
        ['Normal', 'Tren', '3', 20.68900000, -103.34800000],
        ['Independencia', 'Macrobus', 'Calzada', 20.68700000, -103.33800000],
    ];

    private const PRODUCTOS = [
        ['PUL-LITE-N', 'Reloj Pulso Lite, caja negra, correa de silicón', 699, 380],
        ['PUL-LITE-R', 'Reloj Pulso Lite, caja rosa, correa de silicón', 699, 380],
        ['PUL-PRO-P', 'Reloj Pulso Pro con GPS, caja plata', 1299, 760],
        ['BAN-ACT-4', 'Banda Activa 4, pantalla AMOLED', 549, 290],
        ['COR-SIL-22', 'Correa de silicón 22 mm, varios colores', 149, 45],
        ['CAR-MAG-01', 'Cargador magnético para Pulso Lite y Pro', 199, 70],
    ];

    private const ESTADOS_PASADOS = ['Entregado', 'Entregado', 'Entregado', 'Entregado', 'Cancelado - Sin respuesta', 'Cancelado - No recibio'];

    public function run(): void
    {
        mt_srand(2024);
        $hoy = Carbon::today();

        DB::transaction(function () use ($hoy) {
            $roles = collect(['Administrador', 'Vendedor', 'Repartidor'])
                ->mapWithKeys(fn ($nombre) => [$nombre => Role::firstOrCreate(['nombre' => $nombre])->id]);

            User::updateOrCreate(['email' => config('erp.demo.correo')], [
                'name' => 'Cuenta demo',
                'telefono' => 3355500000,
                'idrol' => $roles['Administrador'],
                'password' => config('erp.demo.clave'),
            ]);
            $vendedora = User::updateOrCreate(['email' => 'mariana.lopez@erpneni.test'], [
                'name' => 'Mariana López', 'telefono' => 3355500001, 'idrol' => $roles['Vendedor'], 'password' => Str::random(40),
            ]);
            $repartidor = User::updateOrCreate(['email' => 'jorge.ramirez@erpneni.test'], [
                'name' => 'Jorge Ramírez', 'telefono' => 3355500002, 'idrol' => $roles['Repartidor'], 'password' => Str::random(40),
            ]);

            if (Venta::exists()) {
                return; // La demo ya tiene operaciones.
            }

            $puntos = collect(self::PUNTOS)->map(fn ($p) => Puntos_entrega::create([
                'name' => $p[0], 'clasificacion' => $p[1], 'linea' => $p[2], 'latitud' => $p[3], 'longitud' => $p[4],
            ]));
            $productos = collect(self::PRODUCTOS)->map(fn ($p) => Producto::create([
                'catalogo' => $p[0], 'descripcion' => $p[1], 'precio' => $p[2], 'costo' => $p[3],
            ]));
            $almacenes = collect([
                ['Bodega Centro', 'Calle Ficticia 120, Centro, Guadalajara', 18],
                ['Bodega Zapopan', 'Av. Inventada 45, Zapopan', 30],
            ])->map(fn ($a) => Almacene::create([
                'name' => $a[0], 'direccion' => $a[1], 'idusuario_encargado' => $vendedora->id, 'capacidad_m3' => $a[2],
            ]));
            foreach ($almacenes as $almacen) {
                foreach ($productos as $producto) {
                    Almacen_producto::create(['idalmacen' => $almacen->id, 'idproducto' => $producto->id, 'existencia' => 0]);
                }
            }

            $proveedores = collect([
                ['Distribuidora Relojes del Bajío', 'ventas@relojesdelbajio.test', 4775550101, 'DRB190312AB1'],
                ['Importadora Pulso', 'pedidos@importadorapulso.test', 3355550102, 'IPU200715CD2'],
            ])->map(fn ($p) => Socio::create([
                'name' => $p[0], 'email' => $p[1], 'telefono' => $p[2], 'rfc' => $p[3], 'dias_entrega' => 7,
                'plataforma' => 'Mayoreo', 'tipo' => 'proveedor',
            ]));
            $clientes = collect(self::CLIENTES)->values()->map(fn ($c, $i) => Socio::create([
                'name' => $c[0], 'telefono' => 3355510000 + $i, 'sexo' => $c[1],
                'plataforma' => ['Facebook', 'Instagram', 'WhatsApp'][$i % 3], 'tipo' => 'cliente',
            ]));

            // Compras: llenan los almacenes antes de las ventas.
            foreach ([180, 120, 60, 20] as $hace) {
                foreach ($almacenes as $almacen) {
                    $this->recepcion($hace, $almacen, $proveedores->random(), $productos, $vendedora);
                }
            }

            // Ventas de los últimos cinco meses, más entregas para hoy y para mañana.
            for ($dia = 150; $dia >= -1; $dia -= mt_rand(1, 3)) {
                $fechaEntrega = $hoy->copy()->subDays($dia);
                $estado = match (true) {
                    $dia > 0 => self::ESTADOS_PASADOS[array_rand(self::ESTADOS_PASADOS)],
                    $dia === 0 => 'Confirmado',
                    default => 'Por contactar',
                };
                $this->venta($fechaEntrega, $estado, $almacenes->random(), $clientes->random(), $puntos->random(), $productos, $vendedora, $repartidor);
            }
            foreach ([0, -1] as $dia) {
                foreach (['Por contactar', 'Contactado'] as $estado) {
                    $this->venta($hoy->copy()->subDays($dia), $estado, $almacenes->random(), $clientes->random(), $puntos->random(), $productos, $vendedora, $repartidor);
                }
            }
        });
    }

    private function recepcion(int $hace, Almacene $almacen, Socio $proveedor, $productos, User $usuario): void
    {
        $fecha = Carbon::today()->subDays($hace)->setTime(10, 0);
        $partidas = $productos->map(fn ($p) => ['producto' => $p, 'cantidad' => mt_rand(8, 20)]);
        $total = $partidas->sum(fn ($x) => $x['cantidad'] * $x['producto']->costo);

        $recepcion = new Recepcione([
            'fecha_recepcion' => $fecha->toDateString(), 'idalmacen' => $almacen->id, 'idusuario' => $usuario->id,
            'idsocio' => $proveedor->id, 'forma_pago' => 'SPEI', 'referencia' => 'OC-'.mt_rand(1000, 9999),
            'guia' => 'GUIA'.mt_rand(100000, 999999), 'costos_extras' => 250, 'total' => $total + 250,
        ]);
        $recepcion->created_at = $recepcion->updated_at = $fecha;
        $recepcion->save();

        $movimiento = $this->movimiento(1, $proveedor, $almacen, $usuario, $recepcion->referencia, $fecha);
        foreach ($partidas as $x) {
            $partida = new Recepciones_producto([
                'idrecepcion' => $recepcion->id, 'idproducto' => $x['producto']->id, 'costo' => $x['producto']->costo, 'cantidad' => $x['cantidad'],
            ]);
            $partida->created_at = $partida->updated_at = $fecha;
            $partida->save();
            $this->partidaMovimiento($movimiento, $x['producto'], $x['cantidad'], 'recepciones_productos', $partida->id, $fecha);
            Almacen_producto::ajustarExistencia($almacen->id, $x['producto']->id, $x['cantidad']);
        }
    }

    private function venta(Carbon $fechaEntrega, string $estado, Almacene $almacen, Socio $cliente, Puntos_entrega $punto, $productos, User $vendedora, User $repartidor): void
    {
        $creada = $fechaEntrega->copy()->subDay()->setTime(mt_rand(9, 20), mt_rand(0, 59));
        $partidas = $productos->random(mt_rand(1, 2))->map(fn ($p) => ['producto' => $p, 'cantidad' => mt_rand(1, 2)]);
        $total = $partidas->sum(fn ($x) => $x['cantidad'] * $x['producto']->precio);
        $costoEntrega = [60, 80, 100][mt_rand(0, 2)];

        $entrega = new Entrega([
            'idusuario' => $repartidor->id, 'idpunto_entrega' => $punto->id, 'idsocio' => $cliente->id,
            'fecha' => $fechaEntrega->toDateString(), 'hora' => sprintf('%02d:%02d:00', mt_rand(10, 19), [0, 30][mt_rand(0, 1)]),
            'notas' => $estado === 'Entregado' ? 'Entregado sin novedad.' : '', 'status' => $estado,
            'cobrar_cliente' => $total, 'costo_entrega' => $costoEntrega,
        ]);
        $entrega->created_at = $entrega->updated_at = $creada;
        $entrega->save();

        $venta = new Venta([
            'idsocio' => $cliente->id, 'idalmacen' => $almacen->id, 'identrega' => $entrega->id, 'idusuario' => $vendedora->id,
            'forma_pago' => ['Efectivo', 'Efectivo', 'SPEI', 'Pago en plataforma'][mt_rand(0, 3)], 'total' => $total,
            'notas' => '',
        ]);
        $venta->created_at = $venta->updated_at = $creada;
        $venta->save();
        $venta->folio = 'V'.str_pad((string) $venta->id, 5, '0', STR_PAD_LEFT);
        $venta->save();

        $movimiento = $this->movimiento(2, $cliente, $almacen, $vendedora, $venta->folio, $creada);
        foreach ($partidas as $x) {
            $partida = new Ventas_producto([
                'idventa' => $venta->id, 'idproducto' => $x['producto']->id, 'cantidad' => $x['cantidad'],
                'preciou' => $x['producto']->precio, 'desc_porcentaje' => 0,
            ]);
            $partida->created_at = $partida->updated_at = $creada;
            $partida->save();
            $this->partidaMovimiento($movimiento, $x['producto'], $x['cantidad'], 'ventas_productos', $partida->id, $creada);
            Almacen_producto::ajustarExistencia($almacen->id, $x['producto']->id, -$x['cantidad']);
        }
    }

    private function movimiento(int $tipo, Socio $socio, Almacene $almacen, User $usuario, ?string $referencia, Carbon $fecha): Movimiento
    {
        $movimiento = new Movimiento([
            'idsocio' => $socio->id, 'idalmacen' => $almacen->id, 'idusuario' => $usuario->id, 'idtipo' => $tipo,
            'referencia' => $referencia, 'notas' => '',
        ]);
        $movimiento->created_at = $movimiento->updated_at = $fecha;
        $movimiento->save();

        return $movimiento;
    }

    private function partidaMovimiento(Movimiento $movimiento, Producto $producto, int $cantidad, string $tabla, int $id, Carbon $fecha): void
    {
        $partida = new Movimientos_producto([
            'idmovimiento' => $movimiento->id, 'idproducto' => $producto->id, 'cantidad' => $cantidad,
            'tabla_ref' => $tabla, 'idtabla_ref' => $id,
        ]);
        $partida->created_at = $partida->updated_at = $fecha;
        $partida->save();
    }
}
