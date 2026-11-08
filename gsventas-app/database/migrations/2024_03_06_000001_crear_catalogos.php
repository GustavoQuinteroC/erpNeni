<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// Clientes y proveedores, puntos de entrega, productos, almacenes y tipos de movimiento.
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('socios', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('email', 100)->nullable();
            $table->unsignedBigInteger('telefono')->unique();
            $table->string('domicilio', 100)->nullable();
            $table->string('sexo', 10)->nullable();
            $table->unsignedInteger('dias_entrega')->nullable();
            $table->string('plataforma', 100)->nullable();
            $table->string('rfc', 25)->nullable()->unique();
            $table->enum('tipo', ['cliente', 'proveedor', 'ambos']);
            $table->timestamps();
        });

        Schema::create('puntos_entregas', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('clasificacion', 30)->nullable();
            $table->string('linea', 50)->nullable();
            $table->decimal('latitud', 10, 8)->nullable();
            $table->decimal('longitud', 11, 8)->nullable();
            $table->timestamps();
        });

        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('catalogo', 40)->unique();
            $table->text('descripcion')->nullable();
            $table->decimal('precio', 10, 2)->nullable();
            $table->decimal('costo', 10, 2)->nullable();
            $table->timestamps();
        });

        Schema::create('almacenes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('direccion', 100);
            $table->foreignId('idusuario_encargado')->constrained('users');
            $table->unsignedInteger('capacidad_m3')->nullable();
            $table->timestamps();
        });

        Schema::create('almacen_productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idproducto')->constrained('productos');
            $table->foreignId('idalmacen')->constrained('almacenes');
            $table->integer('existencia')->default(0);
            $table->timestamps();
            $table->unique(['idalmacen', 'idproducto']);
        });

        Schema::create('tipos_movimientos', function (Blueprint $table) {
            $table->id();
            $table->string('concepto', 50)->unique();
            $table->enum('tipo', ['Entrada', 'Salida']);
            $table->timestamps();
        });

        // Los controladores usan estos ids: 1 para recepciones y 2 para ventas.
        DB::table('tipos_movimientos')->insert([
            ['id' => 1, 'concepto' => 'Recepción de mercancía', 'tipo' => 'Entrada', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'concepto' => 'Venta', 'tipo' => 'Salida', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('tipos_movimientos');
        Schema::dropIfExists('almacen_productos');
        Schema::dropIfExists('almacenes');
        Schema::dropIfExists('productos');
        Schema::dropIfExists('puntos_entregas');
        Schema::dropIfExists('socios');
    }
};
