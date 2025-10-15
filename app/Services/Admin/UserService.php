<?php

namespace App\Services\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserService
{
    /**
     * Create a new user
     */
    public function createUser(array $data, int $createdById): array
    {
        $tempPassword = Str::random(10);

        $userData = [
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'institutional_email' => $data['institutional_email'] ?? null,
            'dni' => $data['dni'],
            'phone' => $data['phone'],
            'role' => $data['role'],
            'password' => Hash::make($tempPassword),
            'is_temp_password' => true,
            'temp_password_expires_at' => now()->addDays(7),
            'created_by' => $createdById,
            'is_active' => true,
        ];

        $user = User::create($userData);

        // TODO: Send email if send_credentials is true
        if (isset($data['send_credentials']) && $data['send_credentials']) {
            // Mail::to($user->email)->send(new UserCredentialsMail($user, $tempPassword));
        }

        return [
            'user' => $user,
            'temp_password' => $tempPassword
        ];
    }

    /**
     * Update an existing user
     */
    public function updateUser(User $user, array $data): array
    {
        $updateData = [
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'institutional_email' => $data['institutional_email'] ?? null,
            'role' => $data['role'],
            'is_active' => $data['is_active'] ?? true,
            'dni' => $data['dni'],
            'phone' => $data['phone'],
        ];

        $result = [];

        // Handle password reset
        if (isset($data['reset_temp_password']) && $data['reset_temp_password']) {
            $tempPassword = Str::random(10);
            $updateData['password'] = Hash::make($tempPassword);
            $updateData['is_temp_password'] = true;
            $updateData['temp_password_expires_at'] = now()->addDays(7);
            $result['temp_password'] = $tempPassword;
        }
        // Handle permanent password change
        elseif (isset($data['password']) && $data['password']) {
            $updateData['password'] = Hash::make($data['password']);
            $updateData['is_temp_password'] = false;
            $updateData['temp_password_expires_at'] = null;
        }

        $user->update($updateData);

        return $result;
    }

    /**
     * Delete a user and all related data
     */
    public function deleteUser(User $user): void
    {
        // Delete physical system relations
        $user->bookReservations()->delete();
        $user->bookLoans()->delete();

        // Delete downloads
        $user->downloads()->delete();

        // Delete orders and payments
        $user->orders()->each(function ($order) {
            $order->orderDetails()->delete();
            $order->payment()->delete();
            $order->delete();
        });

        $user->delete();
    }
}
