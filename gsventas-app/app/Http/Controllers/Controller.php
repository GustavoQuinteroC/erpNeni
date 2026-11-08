<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Validation\ValidationException;

abstract class Controller
{
    /**
     * Partidas que llegan como JSON desde las pantallas de captura.
     *
     * @return list<array{id: int, cantidad: int}&array<string, int|float>>
     */
    protected function partidas(?string $json, string $campoImporte): array
    {
        $partidas = json_decode((string) $json, true);
        if (! is_array($partidas) || $partidas === []) {
            throw ValidationException::withMessages(['productos_seleccionados' => 'Agrega al menos un producto.']);
        }

        $limpias = [];
        foreach ($partidas as $partida) {
            $id = filter_var($partida['id'] ?? null, FILTER_VALIDATE_INT);
            $cantidad = filter_var($partida['cantidad'] ?? null, FILTER_VALIDATE_INT);
            $importe = filter_var($partida[$campoImporte] ?? null, FILTER_VALIDATE_FLOAT);
            if ($id === false || $cantidad === false || $cantidad < 1 || $importe === false || $importe < 0) {
                throw ValidationException::withMessages(['productos_seleccionados' => 'Revisa la cantidad y el importe de cada producto.']);
            }
            $limpias[] = ['id' => $id, 'cantidad' => $cantidad, $campoImporte => $importe];
        }

        $ids = array_unique(array_column($limpias, 'id'));
        if (Producto::whereIn('id', $ids)->count() !== count($ids)) {
            throw ValidationException::withMessages(['productos_seleccionados' => 'Uno de los productos ya no existe.']);
        }

        return $limpias;
    }
}
