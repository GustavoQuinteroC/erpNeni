<?php

namespace Tests\Feature;

use App\Models\Almacen_producto;
use App\Models\Almacene;
use App\Models\Producto;
use App\Models\Puntos_entrega;
use App\Models\Role;
use App\Models\Socio;
use App\Models\User;
use App\Models\Venta;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OperacionesTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_la_demo_no_puede_crear_cambiar_ni_borrar(): void
    {
        $demo = User::where('email', config('erp.demo.correo'))->firstOrFail();
        $clientes = Socio::count();

        $this->actingAs($demo)->from(route('clientes.create'))
            ->post(route('clientes.store'), ['name' => 'Cliente nuevo', 'telefono' => 3355599999])
            ->assertRedirect(route('clientes.create'))
            ->assertSessionHas('aviso', 'La cuenta demo es de solo lectura.');
        $this->assertSame($clientes, Socio::count());

        $cliente = Socio::where('tipo', 'cliente')->firstOrFail();
        $this->deleteJson(route('clientes.destroy', $cliente), [], ['X-Requested-With' => 'XMLHttpRequest'])->assertForbidden();
        $this->assertModelExists($cliente);

        $this->from(route('perfil.index'))->put(route('usuarios.update', $demo), ['name' => 'Otro nombre'])
            ->assertSessionHas('aviso');
        $this->assertSame('Cuenta demo', $demo->fresh()->name);
    }

    public function test_una_venta_descuenta_existencia_y_genera_folio(): void
    {
        $usuario = $this->usuarioConPermisos();
        $almacen = Almacene::firstOrFail();
        $producto = Producto::firstOrFail();
        $antes = $this->existencia($almacen, $producto);
        $repartidor = User::where('email', 'jorge.ramirez@erpneni.test')->firstOrFail();

        $this->actingAs($usuario)->from(route('ventas.create'))->post(route('ventas.store'), [
            'telefono' => '3355598765',
            'idalmacen' => $almacen->id,
            'forma_pago' => 'Efectivo',
            'nombre_cliente' => 'Cliente de prueba',
            'nombre_punto' => 'Juárez',
            'idpunto_entrega' => Puntos_entrega::firstOrFail()->id,
            'nombre_usuario' => $repartidor->name,
            'idusuario' => $repartidor->id,
            'costo_entrega' => 80,
            'fecha' => now()->addDay()->toDateString(),
            'hora' => '12:00',
            'total_hidden' => 2 * $producto->precio,
            'productos_seleccionados' => json_encode([['id' => $producto->id, 'precio' => $producto->precio, 'cantidad' => 2]]),
        ])->assertRedirect(route('ventas.create'))->assertSessionHas('message', 'ok')->assertSessionHasNoErrors();

        $venta = Venta::latest('id')->firstOrFail();
        $this->assertSame('V'.str_pad((string) $venta->id, 5, '0', STR_PAD_LEFT), $venta->folio);
        $this->assertSame($antes - 2, $this->existencia($almacen, $producto));
        $this->assertDatabaseHas('socios', ['name' => 'Cliente de prueba', 'tipo' => 'cliente']);
        $this->assertDatabaseHas('movimientos', ['referencia' => $venta->folio, 'idtipo' => 2]);
    }

    public function test_una_venta_sin_productos_no_se_guarda(): void
    {
        $ventas = Venta::count();
        $this->actingAs($this->usuarioConPermisos())->post(route('ventas.store'), [
            'telefono' => '3355598765', 'idalmacen' => Almacene::firstOrFail()->id, 'forma_pago' => 'Efectivo',
            'nombre_cliente' => 'X', 'nombre_punto' => 'Juárez', 'idpunto_entrega' => Puntos_entrega::firstOrFail()->id,
            'nombre_usuario' => 'Y', 'idusuario' => User::firstOrFail()->id, 'costo_entrega' => 80,
            'fecha' => now()->toDateString(), 'hora' => '12:00', 'total_hidden' => 100,
            'productos_seleccionados' => '[]',
        ])->assertSessionHasErrors('productos_seleccionados');
        $this->assertSame($ventas, Venta::count());
    }

    public function test_una_recepcion_suma_existencia(): void
    {
        $almacen = Almacene::firstOrFail();
        $producto = Producto::firstOrFail();
        $antes = $this->existencia($almacen, $producto);

        $this->actingAs($this->usuarioConPermisos())->post(route('recepciones.store'), [
            'selectedSocio' => Socio::where('tipo', 'proveedor')->firstOrFail()->id,
            'idalmacen' => $almacen->id,
            'forma_pago' => 'SPEI',
            'fecha' => now()->toDateString(),
            'referencia' => 'OC-TEST',
            'costos_extras' => 0,
            'total_hidden' => 5 * $producto->costo,
            'productos_seleccionados' => json_encode([['id' => $producto->id, 'costo' => $producto->costo, 'cantidad' => 5]]),
        ])->assertSessionHasNoErrors()->assertSessionHas('message', 'ok');

        $this->assertSame($antes + 5, $this->existencia($almacen, $producto));
    }

    public function test_cambiar_el_estado_de_una_entrega(): void
    {
        $entrega = \App\Models\Entrega::where('status', 'Por contactar')->firstOrFail();
        $this->actingAs($this->usuarioConPermisos())
            ->put(route('entregas.update', $entrega), ['estado' => 'Contactado', 'notas_mensajero' => 'Contestó'])
            ->assertSessionHas('message', 'ok');
        $this->assertSame('Contactado', $entrega->fresh()->status);
    }

    public function test_la_semilla_se_puede_correr_dos_veces(): void
    {
        $ventas = Venta::count();
        $this->seed(DatabaseSeeder::class);
        $this->assertSame($ventas, Venta::count());
        $this->assertSame(1, User::where('email', config('erp.demo.correo'))->count());
    }

    private function usuarioConPermisos(): User
    {
        return User::create([
            'name' => 'Persona de pruebas', 'email' => 'pruebas@erpneni.test', 'telefono' => 3355577777,
            'idrol' => Role::where('nombre', 'Administrador')->value('id'), 'password' => 'clave-de-pruebas',
        ]);
    }

    private function existencia(Almacene $almacen, Producto $producto): int
    {
        return (int) Almacen_producto::where(['idalmacen' => $almacen->id, 'idproducto' => $producto->id])->value('existencia');
    }
}
