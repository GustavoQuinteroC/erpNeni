<?php

use App\Http\Middleware\CabecerasSeguridad;
use App\Http\Middleware\SoloLectura;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Solo se llega al contenedor a través del proxy (Traefik o el Ingress de Kubernetes).
        $middleware->trustProxies(at: '*');
        $middleware->append(CabecerasSeguridad::class);
        $middleware->alias(['solo-lectura' => SoloLectura::class]);
        $middleware->redirectGuestsTo(fn () => route('login'));
        $middleware->redirectUsersTo(fn () => route('dashboard.index'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
