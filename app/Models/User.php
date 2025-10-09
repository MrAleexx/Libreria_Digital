<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'last_name',
        'dni',
        'phone',
        'email',
        'password',
        'role',
        'microsoft_id',
        'institutional_email',
        'is_active',
        'last_login_at',
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
            'role' => 'string',
            'is_active' => 'boolean',
            'last_login_at' => 'datetime',
        ];
    }

    // Roles del sistema
    const ROLE_ADMIN = 'admin';
    const ROLE_MODERATOR = 'moderator';
    const ROLE_USER = 'user';

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isModerator(): bool
    {
        return $this->role === self::ROLE_MODERATOR;
    }

    public function isUser(): bool
    {
        return $this->role === self::ROLE_USER;
    }

    // Verificar si es cuenta institucional
    public function isInstitutional(): bool
    {
        return !is_null($this->microsoft_id);
    }

    // Scope para usuarios activos
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function purchasedItems()
    {
        return OrderDetail::whereHas('order', function ($query) {
            $query->where('user_id', $this->id)
                ->where('status', 'paid');
        })->with(['book', 'order']);
    }

    public function hasPurchased($bookId)
    {
        return $this->purchasedItems()
            ->where('book_id', $bookId)
            ->exists();
    }
}
