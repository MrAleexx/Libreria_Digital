<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookLoan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'physical_copy_id',
        'reservation_id',
        'loan_date',
        'due_date',
        'actual_return_date',
        'renewal_count',
        'status',
    ];

    protected $casts = [
        'loan_date' => 'datetime',
        'due_date' => 'datetime',
        'actual_return_date' => 'datetime',
        'renewal_count' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Estados del préstamo
    const STATUS_ACTIVE = 'active';
    const STATUS_RETURNED = 'returned';
    const STATUS_OVERDUE = 'overdue';

    // Duración del préstamo en días
    const LOAN_DURATION_DAYS = 14;
    const RENEWAL_DURATION_DAYS = 7;
    const MAX_RENEWALS = 2;

    // Relación con el usuario
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relación con el ejemplar físico
    public function physicalCopy(): BelongsTo
    {
        return $this->belongsTo(PhysicalCopy::class);
    }

    // Relación con el libro a través del ejemplar físico
    public function book()
    {
        return $this->hasOneThrough(Book::class, PhysicalCopy::class, 'id', 'id', 'physical_copy_id', 'book_id');
    }

    // Relación con la reserva (opcional)
    public function reservation(): BelongsTo
    {
        return $this->belongsTo(BookReservation::class);
    }

    // Verificar si está activo
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    // Verificar si está devuelto
    public function isReturned(): bool
    {
        return $this->status === self::STATUS_RETURNED;
    }

    // Verificar si está atrasado
    public function isOverdue(): bool
    {
        return $this->status === self::STATUS_OVERDUE ||
            ($this->isActive() && $this->due_date->isPast());
    }

    // Verificar si se puede renovar
    public function canBeRenewed(): bool
    {
        return $this->isActive() &&
            !$this->isOverdue() &&
            $this->renewal_count < self::MAX_RENEWALS;
    }

    // Renovar préstamo
    public function renew(): bool
    {
        if (!$this->canBeRenewed()) {
            return false;
        }

        $newDueDate = $this->due_date->copy()->addDays(self::RENEWAL_DURATION_DAYS);

        return $this->update([
            'due_date' => $newDueDate,
            'renewal_count' => $this->renewal_count + 1,
        ]);
    }

    // Marcar como devuelto
    public function markAsReturned(): bool
    {
        // Marcar el ejemplar como disponible
        $this->physicalCopy->markAsAvailable();

        return $this->update([
            'status' => self::STATUS_RETURNED,
            'actual_return_date' => now(),
        ]);
    }

    // Marcar como atrasado
    public function markAsOverdue(): bool
    {
        if ($this->isActive() && $this->due_date->isPast()) {
            return $this->update(['status' => self::STATUS_OVERDUE]);
        }

        return false;
    }

    // Calcular días de atraso
    public function getDaysOverdueAttribute(): int
    {
        if (!$this->isOverdue()) {
            return 0;
        }

        return now()->diffInDays($this->due_date);
    }

    // Calcular días restantes
    public function getDaysRemainingAttribute(): int
    {
        if ($this->isReturned() || $this->isOverdue()) {
            return 0;
        }

        $remaining = now()->diffInDays($this->due_date, false);
        return max(0, $remaining);
    }

    // Obtener información del estado con color
    public function getStatusInfoAttribute(): array
    {
        if ($this->isOverdue()) {
            return ['label' => 'Atrasado', 'color' => 'danger'];
        }

        return match ($this->status) {
            self::STATUS_ACTIVE => ['label' => 'Activo', 'color' => 'primary'],
            self::STATUS_RETURNED => ['label' => 'Devuelto', 'color' => 'success'],
            self::STATUS_OVERDUE => ['label' => 'Atrasado', 'color' => 'danger'],
            default => ['label' => 'Desconocido', 'color' => 'dark'],
        };
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', self::STATUS_OVERDUE)
            ->orWhere(function ($q) {
                $q->where('status', self::STATUS_ACTIVE)
                    ->where('due_date', '<', now());
            });
    }

    public function scopeReturned($query)
    {
        return $query->where('status', self::STATUS_RETURNED);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeDueSoon($query, $days = 3)
    {
        return $query->where('status', self::STATUS_ACTIVE)
            ->whereBetween('due_date', [now(), now()->addDays($days)]);
    }

    // Auto-marcar como atrasado
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($loan) {
            if ($loan->isActive() && $loan->due_date->isPast()) {
                $loan->status = self::STATUS_OVERDUE;
            }
        });
    }

    public function scopeFiltered($query)
    {
        return $query->when(request('filter') == 'active', function ($q) {
            $q->active();
        })->when(request('filter') == 'overdue', function ($q) {
            $q->overdue();
        })->when(request('filter') == 'returned', function ($q) {
            $q->returned();
        });
    }
}
