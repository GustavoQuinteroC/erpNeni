<?php

namespace Tests\Feature;

use App\Models\Almacene;
use App\Models\Entrega;
use App\Models\Movimiento;
use App\Models\Producto;
use App\Models\Puntos_entrega;
use App\Models\Recepcione;
use App\Models\Socio;
use App\Models\User;
use App\Models\Venta;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ConsultasTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::where('email', config('erp.demo.correo'))->firstOrFail());
    }

    /** @return array<string, array{string}> */
    public static function listados(): array
    {
        return collect(['clientes', 'proveedores', 'ventas', 'usuarios', 'productos', 'almacenes', 'recepciones',
            'movimientos', 'puntos_entregas', 'entregas', 'indexhoy', 'indexmanana'])
            ->mapWithKeys(fn ($ruta) => [$ruta => [$ruta]])->all();
    }

    #[DataProvider('listados')]
    public function test_cada_listado_responde_a_datatables(string $ruta): void
    {
        $respuesta = $this->getJson('/'.$ruta.'?draw=1&start=0&length=10', ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertOk()
            ->assertJsonStructure(['draw', 'recordsTotal', 'recordsFiltered', 'data']);

        if (! in_array($ruta, ['indexhoy', 'indexmanana'], true)) {
            $this->assertGreaterThan(0, $respuesta->json('recordsTotal'), "El listado $ruta viene vacío");
        }
    }

    public function test_hay_entregas_para_hoy_y_para_manana(): void
    {
        foreach (['indexhoy', 'indexmanana'] as $ruta) {
            $total = $this->getJson('/'.$ruta.'?draw=1', ['X-Requested-With' => 'XMLHttpRequest'])->json('recordsTotal');
            $this->assertGreaterThan(0, $total, "No hay entregas en $ruta");
        }
    }

    public function test_el_listado_de_usuarios_no_expone_contrasenas(): void
    {
        $this->getJson('/usuarios?draw=1', ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertOk()
            ->assertDontSee('password')
            ->assertDontSee('remember_token');
    }

    public function test_pantallas_de_detalle(): void
    {
        $venta = Venta::firstOrFail();
        $entrega = Entrega::firstOrFail();
        $cliente = Socio::where('tipo', 'cliente')->firstOrFail();
        $proveedor = Socio::where('tipo', 'proveedor')->firstOrFail();

        $this->get(route('ventas.show', $venta))->assertOk()->assertSee($venta->total);
        $this->get(route('entregas.edit', $entrega))->assertOk();
        $this->get(route('recepciones.edit', Recepcione::firstOrFail()))->assertOk();
        $this->get(route('almacenes.edit', Almacene::firstOrFail()))->assertOk();
        $this->get(route('movimientos.show', Movimiento::firstOrFail()))->assertOk();
        $this->get(route('clientes.edit', $cliente))->assertOk()->assertSee($cliente->name);
        $this->get(route('proveedores.edit', $proveedor))->assertOk()->assertSee($proveedor->name);
        $this->get(route('productos.edit', Producto::firstOrFail()))->assertOk();
        $this->get(route('usuarios.edit', User::firstOrFail()))->assertOk();
        $this->getJson(route('puntos_entregas.edit', Puntos_entrega::firstOrFail()))->assertOk()->assertJsonStructure(['name', 'latitud']);
    }

    public function test_comisiones_por_rango_de_fechas(): void
    {
        $rango = ['fechaInicio' => now()->subDays(60)->getTimestampMs(), 'fechaFin' => now()->getTimestampMs()];
        $ajax = ['X-Requested-With' => 'XMLHttpRequest'];

        $vendedor = $this->getJson(route('comisionesVendedor.index', $rango), $ajax)->assertOk();
        $this->assertNotEmpty($vendedor->json('data'));
        $this->assertGreaterThan(0, $vendedor->json('totalComisiones'));

        $repartidor = $this->getJson(route('comisionesRepartidor.index', $rango), $ajax)->assertOk();
        $this->assertGreaterThan(0, $repartidor->json('totalCostoEntrega'));
    }

    public function test_buscadores_y_productos(): void
    {
        $ajax = ['X-Requested-With' => 'XMLHttpRequest'];
        $this->getJson(route('clientes.buscar', ['search' => 'a']), $ajax)->assertOk()->assertJsonStructure([['id', 'name', 'telefono']]);
        $this->getJson(route('proveedores.buscar', ['search' => 'a']), $ajax)->assertOk()->assertJsonStructure([['id']]);
        $this->getJson(route('usuarios.buscar', ['search' => 'a']), $ajax)->assertOk()->assertJsonStructure([['id']]);
        $this->getJson(route('puntos_entregas.buscar', ['search' => 'a']), $ajax)->assertOk()->assertJsonStructure([['id']]);
        $this->getJson(route('productos.getAllProducts'))->assertOk()->assertJsonCount(Producto::count());
        $this->getJson(route('productos.getProductsForAlmacen', ['idalmacen' => Almacene::firstOrFail()->id]))->assertOk()->assertJsonCount(Producto::count());
        // Consulta por POST: la demo de solo lectura sí puede usarla.
        $this->postJson(route('productos.getInfo'), ['productos' => [Producto::firstOrFail()->id]])->assertOk()->assertJsonCount(1);
    }

    public function test_el_tablero_tiene_ventas_del_mes(): void
    {
        $this->get('/')->assertOk()->assertViewHas('totalVentas', fn ($total) => $total > 0);
    }
}
