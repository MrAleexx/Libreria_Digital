<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PhysicalCopy extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'barcode',
        'copy_number',
        'status',
        'location',
        'notes',
    ];

    protected $casts = [
        'copy_number' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Estados disponibles
    const STATUS_AVAILABLE = 'available';
    const STATUS_RESERVED = 'reserved';
    const STATUS_LOANED = 'loaned';
    const STATUS_MAINTENANCE = 'maintenance';

    // Relación con el libro
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    // Relación con reservas activas
    public function activeReservation()
    {
        return $this->hasOne(BookReservation::class)
            ->whereIn('status', ['pending', 'ready_for_pickup']);
    }

    // Relación con préstamos activos
    public function activeLoan()
    {
        return $this->hasOne(BookLoan::class)
            ->where('status', 'active');
    }

    // Relación con todos los préstamos
    public function loans(): HasMany
    {
        return $this->hasMany(BookLoan::class);
    }

    // Relación con todas las reservas
    public function reservations(): HasMany
    {
        return $this->hasMany(BookReservation::class);
    }

    // Verificar si está disponible
    public function isAvailable(): bool
    {
        return $this->status === self::STATUS_AVAILABLE;
    }

    // Verificar si está reservado
    public function isReserved(): bool
    {
        return $this->status === self::STATUS_RESERVED;
    }

    // Verificar si está prestado
    public function isLoaned(): bool
    {
        return $this->status === self::STATUS_LOANED;
    }

    // Verificar si está en mantenimiento
    public function isInMaintenance(): bool
    {
        return $this->status === self::STATUS_MAINTENANCE;
    }

    // Marcar como disponible
    public function markAsAvailable(): bool
    {
        return $this->update(['status' => self::STATUS_AVAILABLE]);
    }

    // Marcar como reservado
    public function markAsReserved(): bool
    {
        return $this->update(['status' => self::STATUS_RESERVED]);
    }

    // Marcar como prestado
    public function markAsLoaned(): bool
    {
        return $this->update(['status' => self::STATUS_LOANED]);
    }

    // Marcar como en mantenimiento
    public function markAsMaintenance(): bool
    {
        return $this->update(['status' => self::STATUS_MAINTENANCE]);
    }

    // Obtener el identificador único del ejemplar
    public function getUniqueIdentifierAttribute(): string
    {
        return "{$this->book->isbn}-COPIA-{$this->copy_number}";
    }

    // Obtener información del estado con color
    public function getStatusInfoAttribute(): array
    {
        return match ($this->status) {
            self::STATUS_AVAILABLE => ['label' => 'Disponible', 'color' => 'success'],
            self::STATUS_RESERVED => ['label' => 'Reservado', 'color' => 'warning'],
            self::STATUS_LOANED => ['label' => 'Prestado', 'color' => 'primary'],
            self::STATUS_MAINTENANCE => ['label' => 'Mantenimiento', 'color' => 'secondary'],
            default => ['label' => 'Desconocido', 'color' => 'dark'],
        };
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('status', self::STATUS_AVAILABLE);
    }

    public function scopeReserved($query)
    {
        return $query->where('status', self::STATUS_RESERVED);
    }

    public function scopeLoaned($query)
    {
        return $query->where('status', self::STATUS_LOANED);
    }

    public function scopeInMaintenance($query)
    {
        return $query->where('status', self::STATUS_MAINTENANCE);
    }

    public function scopeByBook($query, $bookId)
    {
        return $query->where('book_id', $bookId);
    }
}
