<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AccesoTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    /** @return array<string, array{string}> */
    public static function paginas(): array
    {
        return collect([
            '/', 'clientes', 'clientes/create', 'proveedores', 'proveedores/create', 'ventas', 'ventas/create',
            'usuarios', 'usuarios/create', 'productos', 'productos/create', 'almacenes', 'almacenes/create',
            'recepciones', 'recepciones/create', 'movimientos', 'inventarios', 'inventarios?almacen_id=1',
            'puntos_entregas', 'entregas', 'indexhoy', 'indexmanana', 'comisionesVendedor', 'comisionesRepartidor',
            'generador_rutas', 'perfil',
        ])->mapWithKeys(fn ($ruta) => [$ruta => [$ruta]])->all();
    }

    #[DataProvider('paginas')]
    public function test_sin_sesion_manda_al_login(string $ruta): void
    {
        $this->get('/'.ltrim($ruta, '/'))->assertRedirect(route('login'));
    }

    #[DataProvider('paginas')]
    public function test_la_demo_ve_cada_pagina(string $ruta): void
    {
        $this->actingAs($this->demo())->get('/'.ltrim($ruta, '/'))->assertOk();
    }

    public function test_el_login_muestra_la_cuenta_demo_y_deja_entrar(): void
    {
        $this->get(route('login'))->assertOk()
            ->assertSee(config('erp.demo.correo'))
            ->assertSee(config('erp.demo.clave'));

        $this->post(route('login'), ['email' => config('erp.demo.correo'), 'password' => config('erp.demo.clave')])
            ->assertRedirect(route('dashboard.index'));
        $this->assertAuthenticatedAs($this->demo());
    }

    public function test_contrasena_incorrecta_no_entra(): void
    {
        $this->from(route('login'))
            ->post(route('login'), ['email' => config('erp.demo.correo'), 'password' => 'no-es-esta'])
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_no_hay_registro_ni_recuperacion_de_contrasena(): void
    {
        $this->get('/register')->assertNotFound();
        $this->get('/password/reset')->assertNotFound();
    }

    public function test_salir_cierra_la_sesion(): void
    {
        $this->actingAs($this->demo())->post(route('logout'))->assertRedirect(route('login'));
        $this->assertGuest();
    }

    private function demo(): User
    {
        return User::where('email', config('erp.demo.correo'))->firstOrFail();
    }
}
