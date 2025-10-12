<?php
// app/Http/Controllers/Auth/MicrosoftAuthController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class MicrosoftAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('microsoft')->redirect();
    }

    public function callback(Request $request)
    {
        try {
            $microsoftUser = Socialite::driver('microsoft')->user();

            // VERIFICACIÓN EXTRA: Solo cuentas institucionales
            if (!$this->isValidInstitutionalAccount($microsoftUser)) {
                \Log::warning('Intento de login con cuenta no institucional: ' . $microsoftUser->getEmail());
                return redirect()->route('login')
                    ->with('mensaje', 'Solo se permiten cuentas institucionales autorizadas.');
            }

            $user = $this->findOrCreateUser($microsoftUser);

            // VERIFICACIÓN: Usuario debe estar activo en TU sistema
            if (!$user->is_active) {
                \Log::warning('Usuario institucional inactivo intentó login: ' . $microsoftUser->getEmail());
                return redirect()->route('login')
                    ->with('mensaje', 'Tu cuenta no está activa en nuestro sistema. Contacta al administrador.');
            }

            Auth::login($user, true);
            \Log::info('Login exitoso institucional: ' . $microsoftUser->getEmail());

            return redirect()->intended(route('bookmart'))
                ->with('success', '¡Bienvenido a OpenReads!');
        } catch (\Exception $e) {
            \Log::error('Error autenticación institucional: ' . $e->getMessage());
            return redirect()->route('login')
                ->with('mensaje', 'Error en la autenticación. Contacta a soporte si el problema persiste.');
        }
    }

    private function findOrCreateUser($microsoftUser)
    {
        // Buscar por Microsoft ID primero
        $user = User::where('microsoft_id', $microsoftUser->getId())->first();

        if (!$user) {
            // Buscar por email institucional
            $user = User::where('institutional_email', $microsoftUser->getEmail())->first();

            if (!$user) {
                // Verificar si el usuario ya existe por email normal
                $user = User::where('email', $microsoftUser->getEmail())->first();

                if ($user) {
                    // Actualizar usuario existente con datos Microsoft
                    $user->update([
                        'microsoft_id' => $microsoftUser->getId(),
                        'institutional_email' => $microsoftUser->getEmail(),
                        'email_verified_at' => now(),
                    ]);
                } else {
                    // Crear nuevo usuario institucional
                    $user = User::create([
                        'name' => $microsoftUser->getName() ?? $microsoftUser->getEmail(),
                        'last_name' => '', // Se puede obtener del nombre si está disponible
                        'dni' => null, // No requerido para cuentas institucionales
                        'phone' => null, // No requerido para cuentas institucionales
                        'email' => $microsoftUser->getEmail(),
                        'institutional_email' => $microsoftUser->getEmail(),
                        'microsoft_id' => $microsoftUser->getId(),
                        'password' => Hash::make(Str::random(16)),
                        'email_verified_at' => now(),
                        'role' => User::ROLE_USER,
                        'is_active' => true,
                    ]);
                }
            } else {
                // Actualizar usuario existente con Microsoft ID
                $user->update([
                    'microsoft_id' => $microsoftUser->getId(),
                    'email_verified_at' => now(),
                ]);
            }
        }

        return $user;
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('bookmart');
    }


    private function isValidInstitutionalAccount($microsoftUser): bool
    {
        $email = $microsoftUser->getEmail();

        // 1. Verificar que el email existe
        if (empty($email)) {
            return false;
        }

        // 2. Verificar dominio institucional
        $domain = Str::after($email, '@');
        $institutionalDomains = [
            'edu.pe',
            'gob.pe',
            'muni.pe',
            'university.edu',
            'school.edu', // ejemplos genéricos
        ];

        // 3. O verificar que NO es dominio personal
        $personalDomains = [
            'gmail.com',
            'hotmail.com',
            'outlook.com',
            'yahoo.com',
            'icloud.com'
        ];

        return !in_array($domain, $personalDomains);
    }
}
