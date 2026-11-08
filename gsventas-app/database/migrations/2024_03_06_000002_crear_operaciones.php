<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Entregas, ventas, recepciones y movimientos de almacén con sus partidas.
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entregas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idusuario')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('idpunto_entrega')->constrained('puntos_entregas');
            $table->foreignId('idsocio')->constrained('socios');
            $table->date('fecha');
            $table->time('hora');
            $table->string('referencia', 20)->nullable();
            $table->text('notas')->nullable();
            $table->string('status', 40)->default('Por contactar');
            $table->decimal('cobrar_cliente', 10, 2)->nullable();
            $table->decimal('costo_entrega', 10, 2)->nullable();
            $table->timestamps();
        });

        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idsocio')->constrained('socios');
            $table->foreignId('idalmacen')->constrained('almacenes');
            $table->foreignId('identrega')->nullable()->constrained('entregas')->nullOnDelete();
            $table->foreignId('idusuario')->constrained('users');
            $table->string('forma_pago', 30);
            $table->string('folio', 10)->nullable()->unique();
            $table->string('referencia', 20)->nullable();
            $table->string('cuenta_pago', 30)->nullable();
            $table->decimal('total', 10, 2);
            $table->text('notas')->nullable();
            $table->timestamps();
        });

        Schema::create('ventas_productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idventa')->constrained('ventas')->cascadeOnDelete();
            $table->foreignId('idproducto')->constrained('productos');
            $table->integer('cantidad');
            $table->decimal('preciou', 10, 2);
            $table->decimal('desc_porcentaje', 5, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('recepciones', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_recepcion');
            $table->foreignId('idalmacen')->constrained('almacenes');
            $table->foreignId('idusuario')->constrained('users');
            $table->foreignId('idsocio')->constrained('socios');
            $table->string('forma_pago', 30);
            $table->string('referencia', 20)->nullable();
            $table->string('cuenta_pago', 30)->nullable();
            $table->string('guia', 50)->nullable();
            $table->decimal('costos_extras', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->timestamps();
        });

        Schema::create('recepciones_productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idrecepcion')->constrained('recepciones')->cascadeOnDelete();
            $table->foreignId('idproducto')->constrained('productos');
            $table->decimal('costo', 10, 2);
            $table->integer('cantidad');
            $table->timestamps();
        });

        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idsocio')->nullable()->constrained('socios')->nullOnDelete();
            $table->foreignId('idalmacen')->constrained('almacenes');
            $table->foreignId('idusuario')->constrained('users');
            $table->foreignId('idtipo')->constrained('tipos_movimientos');
            $table->string('referencia', 20)->nullable();
            $table->text('notas')->nullable();
            $table->timestamps();
        });

        Schema::create('movimientos_productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idmovimiento')->constrained('movimientos')->cascadeOnDelete();
            $table->foreignId('idproducto')->constrained('productos');
            $table->integer('cantidad');
            $table->string('tabla_ref', 50)->nullable();
            $table->unsignedBigInteger('idtabla_ref')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movimientos_productos');
        Schema::dropIfExists('movimientos');
        Schema::dropIfExists('recepciones_productos');
        Schema::dropIfExists('recepciones');
        Schema::dropIfExists('ventas_productos');
        Schema::dropIfExists('ventas');
        Schema::dropIfExists('entregas');
    }
};
