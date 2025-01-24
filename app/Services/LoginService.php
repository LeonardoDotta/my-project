<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginService
{
    public function authenticate(array $credentials)
    {
        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['Credenciais inválidas.'],
            ]);
        }

        return Auth::user();
    }

    public function logout()
    {
        Auth::logout();
    }
}