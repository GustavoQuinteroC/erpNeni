<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/** La cuenta demo puede ver todo el sistema, pero no crear, cambiar ni borrar. */
class SoloLectura
{
    /** Rutas POST que solo consultan datos. */
    private const CONSULTAS = ['productos.getInfo'];

    public function handle(Request $peticion, Closure $siguiente): Response
    {
        $usuario = $peticion->user();
        if ($usuario instanceof User && $usuario->esDemo() && ! $peticion->isMethodSafe()
            && ! $peticion->routeIs(...self::CONSULTAS)) {
            $mensaje = 'La cuenta demo es de solo lectura.';
            if ($peticion->ajax() || $peticion->expectsJson()) {
                return response()->json(['message' => $mensaje], 403);
            }

            return back()->with('aviso', $mensaje);
        }

        return $siguiente($peticion);
    }
}
