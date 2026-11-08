<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'telefono',
        'ine',
        'domicilio',
        'rfc',
        'idrol',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /** @return BelongsTo<Role, $this> */
    public function rol(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'idrol');
    }

    public function esDemo(): bool
    {
        return strcasecmp($this->email, (string) config('erp.demo.correo')) === 0;
    }
}
