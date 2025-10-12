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
        // NUEVOS CAMPOS
        'is_temp_password',
        'temp_password_expires_at',
        'downloads_today',
        'last_download_reset',
        'created_by',
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
            // NUEVOS CASTS
            'is_temp_password' => 'boolean',
            'temp_password_expires_at' => 'datetime',
            'downloads_today' => 'integer',
            'last_download_reset' => 'date',
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

    // NUEVO: Verificar si la contraseña temporal está expirada
    public function isTempPasswordExpired(): bool
    {
        return $this->is_temp_password &&
            $this->temp_password_expires_at &&
            $this->temp_password_expires_at->isPast();
    }

    // NUEVO: Verificar si puede descargar (límite de 5 por día)
    public function canDownload(): bool
    {
        $this->resetDailyDownloadsIfNeeded();
        return $this->downloads_today < 5;
    }

    // NUEVO: Resetear contador de descargas si es nuevo día
    public function resetDailyDownloadsIfNeeded(): void
    {
        if (!$this->last_download_reset || $this->last_download_reset->lt(now()->startOfDay())) {
            $this->update([
                'downloads_today' => 0,
                'last_download_reset' => now()->startOfDay()
            ]);
            $this->refresh();
        }
    }

    // NUEVO: Incrementar contador de descargas
    public function incrementDownloads(): void
    {
        $this->resetDailyDownloadsIfNeeded();
        $this->increment('downloads_today');
    }

    // NUEVO: Relación con el admin que creó el usuario
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // NUEVO: Relación con las descargas
    public function downloads()
    {
        return $this->hasMany(UserDownload::class);
    }

    // NUEVO: Scope para usuarios con contraseñas temporales
    public function scopeWithTempPassword($query)
    {
        return $query->where('is_temp_password', true)
            ->where(function ($q) {
                $q->whereNull('temp_password_expires_at')
                    ->orWhere('temp_password_expires_at', '>', now());
            });
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
