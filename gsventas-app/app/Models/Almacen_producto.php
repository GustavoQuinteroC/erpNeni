<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Almacen_producto extends Model
{
    protected $guarded = [];

    /** Suma (o resta, con cantidad negativa) existencia del producto en el almacén. */
    public static function ajustarExistencia(int $idalmacen, int $idproducto, int $cantidad): void
    {
        $fila = static::firstOrCreate(
            ['idalmacen' => $idalmacen, 'idproducto' => $idproducto],
            ['existencia' => 0],
        );
        $fila->increment('existencia', $cantidad);
    }
}
