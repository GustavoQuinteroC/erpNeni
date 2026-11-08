<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ComandoUsuarioTest extends TestCase
{
    use RefreshDatabase;

    public function test_crea_un_administrador_con_la_contrasena_escrita(): void
    {
        $this->artisan('erp:usuario', ['correo' => 'admin@ejemplo.mx', 'nombre' => 'Admin', 'telefono' => '3311112222'])
            ->expectsQuestion('Contraseña (mínimo 10 caracteres)', 'una-clave-larga')
            ->assertSuccessful();

        $usuario = User::where('email', 'admin@ejemplo.mx')->firstOrFail();
        $this->assertTrue(password_verify('una-clave-larga', $usuario->password));
        $this->assertSame('Administrador', $usuario->rol->nombre);
        $this->assertFalse($usuario->esDemo());
    }

    public function test_rechaza_una_contrasena_corta(): void
    {
        $this->artisan('erp:usuario', ['correo' => 'admin@ejemplo.mx', 'nombre' => 'Admin', 'telefono' => '3311112222'])
            ->expectsQuestion('Contraseña (mínimo 10 caracteres)', 'corta')
            ->assertFailed();
        $this->assertDatabaseMissing('users', ['email' => 'admin@ejemplo.mx']);
    }
}
