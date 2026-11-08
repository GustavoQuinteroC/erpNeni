<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class LoginController extends Controller
{
    private const INTENTOS = 5;

    public function mostrar(): View
    {
        return view('auth.login', ['demo' => config('erp.demo')]);
    }

    public function entrar(Request $peticion): RedirectResponse
    {
        $datos = $peticion->validate([
            'email' => ['required', 'string', 'email', 'max:100'],
            'password' => ['required', 'string', 'max:200'],
        ]);

        $llave = Str::lower($datos['email']).'|'.$peticion->ip();
        if (RateLimiter::tooManyAttempts($llave, self::INTENTOS)) {
            throw ValidationException::withMessages([
                'email' => 'Demasiados intentos. Espera '.RateLimiter::availableIn($llave).' segundos.',
            ]);
        }

        if (! Auth::attempt($datos, $peticion->boolean('remember'))) {
            RateLimiter::hit($llave, 60);
            throw ValidationException::withMessages(['email' => 'El correo o la contraseña no son correctos.']);
        }

        RateLimiter::clear($llave);
        $peticion->session()->regenerate();

        return redirect()->intended(route('dashboard.index'));
    }

    public function salir(Request $peticion): RedirectResponse
    {
        Auth::logout();
        $peticion->session()->invalidate();
        $peticion->session()->regenerateToken();

        return redirect()->route('login');
    }
}
