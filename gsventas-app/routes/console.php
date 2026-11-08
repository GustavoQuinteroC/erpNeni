<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;

Artisan::command('erp:usuario {correo} {nombre} {telefono}', function (string $correo, string $nombre, string $telefono) {
    $clave = $this->secret('Contraseña (mínimo 10 caracteres)');
    $validador = Validator::make(compact('correo', 'nombre', 'telefono', 'clave'), [
        'correo' => 'required|email|max:100|unique:users,email',
        'nombre' => 'required|string|max:100|unique:users,name',
        'telefono' => 'required|digits:10|unique:users,telefono',
        'clave' => 'required|string|min:10|max:200',
    ]);
    if ($validador->fails()) {
        foreach ($validador->errors()->all() as $error) {
            $this->error($error);
        }

        return 1;
    }

    User::create([
        'name' => $nombre, 'email' => $correo, 'telefono' => $telefono, 'password' => $clave,
        'idrol' => Role::firstOrCreate(['nombre' => 'Administrador'])->id,
    ]);
    $this->info("Usuario $correo creado con rol Administrador.");

    return 0;
})->purpose('Crea un usuario administrador que puede capturar (la cuenta demo solo consulta)');
