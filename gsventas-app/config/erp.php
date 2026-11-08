<?php

return [
    // Cuenta pública de demostración: entra a todo el sistema en modo de solo lectura.
    'demo' => [
        'correo' => env('DEMO_CORREO', 'demo@erpneni.test'),
        'clave' => env('DEMO_CLAVE', 'demo-erp-neni'),
    ],
];
