<?php

namespace App\Services\User\Auth;

use Illuminate\Support\Facades\Auth;

class LoginService
{
    public function attempt(array $credentials): array
    {
        $remember = $credentials['remember'] ?? false;
        unset($credentials['remember']);

        if (Auth::attempt($credentials, $remember)) {
            return ['success' => true];
        }

        return [
            'success' => false,
            'message' => 'The provided credentials do not match our records.'
        ];
    }

    public function logout(): void
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }
}