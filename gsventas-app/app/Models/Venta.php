<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    public function socio()
    {
        return $this->belongsTo(Socio::class, 'idsocio');
    }

    public function entrega()
    {
        return $this->belongsTo(Entrega::class, 'identrega');
    }
    protected $guarded = [];
}
