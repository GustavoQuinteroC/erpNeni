<?php

use App\Http\Controllers\AlmaceneController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ComisionesRepartidorController;
use App\Http\Controllers\ComisionesVendedorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EntregaController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\MovimientoController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedoreController;
use App\Http\Controllers\PuntosEntregaController;
use App\Http\Controllers\RecepcioneController;
use App\Http\Controllers\RutasController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VentaController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'mostrar'])->name('login');
    Route::post('login', [LoginController::class, 'entrar'])->middleware('throttle:20,1');
});
Route::post('logout', [LoginController::class, 'salir'])->middleware('auth')->name('logout');

Route::middleware(['auth', 'solo-lectura'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::redirect('home', '/');

    Route::resource('clientes', ClienteController::class)->except('show')
        ->parameters(['clientes' => 'cliente']);
    Route::resource('proveedores', ProveedoreController::class)->except('show')
        ->parameters(['proveedores' => 'proveedore']);
    Route::resource('ventas', VentaController::class)->only(['index', 'create', 'store', 'show']);
    Route::resource('usuarios', UsuarioController::class)->except('show');
    Route::resource('productos', ProductoController::class)->except('show');
    Route::resource('almacenes', AlmaceneController::class)->only(['index', 'create', 'store', 'edit', 'update'])
        ->parameters(['almacenes' => 'almacene']);
    Route::resource('recepciones', RecepcioneController::class)->only(['index', 'create', 'store', 'edit'])
        ->parameters(['recepciones' => 'recepcione']);
    Route::resource('movimientos', MovimientoController::class)->only(['index', 'show']);
    Route::get('inventarios', [InventarioController::class, 'index'])->name('inventarios.index');
    Route::resource('puntos_entregas', PuntosEntregaController::class)->only(['index', 'store', 'edit', 'update']);
    Route::resource('entregas', EntregaController::class)->only(['index', 'edit', 'update']);
    Route::get('comisionesVendedor', [ComisionesVendedorController::class, 'index'])->name('comisionesVendedor.index');
    Route::get('comisionesRepartidor', [ComisionesRepartidorController::class, 'index'])->name('comisionesRepartidor.index');
    Route::get('generador_rutas', [RutasController::class, 'index'])->name('generador_rutas.index');
    Route::get('perfil', [PerfilController::class, 'index'])->name('perfil.index');

    Route::get('buscar-clientes', [ClienteController::class, 'buscar'])->name('clientes.buscar');
    Route::get('buscar-proveedores', [ProveedoreController::class, 'buscar'])->name('proveedores.buscar');
    Route::get('buscar-usuario', [UsuarioController::class, 'buscar'])->name('usuarios.buscar');
    Route::get('buscar-puntos_entregas', [PuntosEntregaController::class, 'buscar'])->name('puntos_entregas.buscar');
    Route::get('getAllProducts', [ProductoController::class, 'getAllProducts'])->name('productos.getAllProducts');
    Route::get('getProductsForAlmacen', [ProductoController::class, 'getProductsForAlmacen'])->name('productos.getProductsForAlmacen');
    Route::post('productos/getInfo', [ProductoController::class, 'getInfo'])->name('productos.getInfo');
    Route::get('indexhoy', [EntregaController::class, 'indexhoy'])->name('entregas.indexhoy');
    Route::get('indexmanana', [EntregaController::class, 'indexmanana'])->name('entregas.indexmanana');
});
