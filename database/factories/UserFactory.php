<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'dni' => fake()->unique()->numerify('########'),
            'phone' => fake()->unique()->numerify('9#######'),
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'is_temp_password' => false,
            'temp_password_expires_at' => null,
            'role' => 'user',
            'downloads_today' => 0,
            'last_download_reset' => now()->toDateString(),
            'created_by' => null,
            'is_active' => true,
            'last_login_at' => null,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function admin(): static
    {
        return $this->state(fn(array $attributes) => [
            'role' => 'admin',
            'email' => 'admin@ebooks.com',
            'is_temp_password' => false,
        ]);
    }

    public function librarian(): static
    {
        return $this->state(fn(array $attributes) => [
            'role' => 'librarian',
        ]);
    }

    public function user(): static
    {
        return $this->state(fn(array $attributes) => [
            'role' => 'user',
        ]);
    }

    public function withTempPassword(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_temp_password' => true,
            'temp_password_expires_at' => now()->addDays(7),
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_active' => false,
        ]);
    }

    public function createdBy(User $user): static
    {
        return $this->state(fn(array $attributes) => [
            'created_by' => $user->id,
        ]);
    }
}
