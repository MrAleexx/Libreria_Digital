<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookReservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'physical_copy_id',
        'reservation_date',
        'pickup_deadline',
        'status',
    ];

    protected $casts = [
        'reservation_date' => 'datetime',
        'pickup_deadline' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Estados de reserva
    const STATUS_PENDING = 'pending';
    const STATUS_READY_FOR_PICKUP = 'ready_for_pickup';
    const STATUS_PICKED_UP = 'picked_up';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_EXPIRED = 'expired';

    // Relación con el usuario
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relación con el libro
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    // Relación con el ejemplar físico asignado
    public function physicalCopy(): BelongsTo
    {
        return $this->belongsTo(PhysicalCopy::class);
    }

    // Relación con el préstamo generado (si aplica)
    public function loan(): HasOne
    {
        return $this->hasOne(BookLoan::class, 'reservation_id');
    }

    // Verificar si está pendiente
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    // Verificar si está lista para recoger
    public function isReadyForPickup(): bool
    {
        return $this->status === self::STATUS_READY_FOR_PICKUP;
    }

    // Verificar si fue recogida
    public function isPickedUp(): bool
    {
        return $this->status === self::STATUS_PICKED_UP;
    }

    // Verificar si está cancelada
    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    // Verificar si está expirada
    public function isExpired(): bool
    {
        return $this->status === self::STATUS_EXPIRED ||
            ($this->isPending() && $this->pickup_deadline->isPast());
    }

    // Verificar si está activa (no cancelada ni expirada)
    public function isActive(): bool
    {
        return in_array($this->status, [self::STATUS_PENDING, self::STATUS_READY_FOR_PICKUP]);
    }

    // Marcar como lista para recoger
    public function markAsReadyForPickup(): bool
    {
        return $this->update(['status' => self::STATUS_READY_FOR_PICKUP]);
    }

    // Marcar como recogida
    public function markAsPickedUp(): bool
    {
        return $this->update(['status' => self::STATUS_PICKED_UP]);
    }

    // Marcar como cancelada
    public function markAsCancelled(): bool
    {
        // Liberar el ejemplar físico si estaba asignado
        if ($this->physical_copy_id) {
            $this->physicalCopy->markAsAvailable();
        }

        return $this->update(['status' => self::STATUS_CANCELLED]);
    }

    // Marcar como expirada
    public function markAsExpired(): bool
    {
        // Liberar el ejemplar físico si estaba asignado
        if ($this->physical_copy_id) {
            $this->physicalCopy->markAsAvailable();
        }

        return $this->update(['status' => self::STATUS_EXPIRED]);
    }

    // Verificar si se puede cancelar
    public function canBeCancelled(): bool
    {
        return $this->isPending() || $this->isReadyForPickup();
    }

    // Obtener tiempo restante para recoger
    public function getTimeRemainingAttribute(): ?string
    {
        if (!$this->pickup_deadline || !$this->isActive()) {
            return null;
        }

        $now = now();
        $deadline = $this->pickup_deadline;

        if ($deadline->isPast()) {
            return 'Expirado';
        }

        // Calcular diferencia total en horas
        $totalHours = $now->diffInHours($deadline, false);

        if ($totalHours <= 0) {
            return 'Expirado';
        }

        // Si hay más de 24 horas, mostrar en días
        if ($totalHours >= 24) {
            $days = floor($totalHours / 24);
            return $days . ($days === 1 ? ' día' : ' días');
        }

        // Si hay más de 1 hora, mostrar en horas
        if ($totalHours >= 1) {
            return $totalHours . ($totalHours === 1 ? ' hora' : ' horas');
        }

        // Menos de 1 hora, mostrar en minutos
        $minutes = $now->diffInMinutes($deadline, false);
        return max(0, $minutes) . ($minutes === 1 ? ' minuto' : ' minutos');
    }

    // Obtener información del estado con color
    public function getStatusInfoAttribute(): array
    {
        return match ($this->status) {
            self::STATUS_PENDING => ['label' => 'Pendiente', 'color' => 'warning'],
            self::STATUS_READY_FOR_PICKUP => ['label' => 'Listo para recoger', 'color' => 'info'],
            self::STATUS_PICKED_UP => ['label' => 'Recogido', 'color' => 'success'],
            self::STATUS_CANCELLED => ['label' => 'Cancelado', 'color' => 'secondary'],
            self::STATUS_EXPIRED => ['label' => 'Expirado', 'color' => 'danger'],
            default => ['label' => 'Desconocido', 'color' => 'dark'],
        };
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeReadyForPickup($query)
    {
        return $query->where('status', self::STATUS_READY_FOR_PICKUP);
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', [self::STATUS_PENDING, self::STATUS_READY_FOR_PICKUP]);
    }

    public function scopeExpired($query)
    {
        return $query->where('status', self::STATUS_EXPIRED)
            ->orWhere(function ($q) {
                $q->where('status', self::STATUS_PENDING)
                    ->where('pickup_deadline', '<', now());
            });
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByBook($query, $bookId)
    {
        return $query->where('book_id', $bookId);
    }

    // Auto-expirar reservas pendientes vencidas
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($reservation) {
            if ($reservation->isPending() && $reservation->pickup_deadline->isPast()) {
                $reservation->status = self::STATUS_EXPIRED;
            }
        });
    }

    public function scopeFiltered($query)
    {
        return $query->when(request('filter') == 'active', function ($q) {
            $q->active();
        })->when(request('filter') == 'pending', function ($q) {
            $q->pending();
        })->when(request('filter') == 'expired', function ($q) {
            $q->expired();
        });
    }
}
