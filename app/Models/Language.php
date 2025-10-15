<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Language extends Model
{
    protected $primaryKey = 'code';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'code',
        'name',
        'native_name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relación con libros
    public function books(): HasMany
    {
        return $this->hasMany(Book::class, 'language_code', 'code');
    }

    // Scope para idiomas activos
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Obtener estadísticas del idioma
    public function getStatsAttribute(): array
    {
        $totalBooks = $this->books()->count();
        $digitalBooks = $this->books()->digital()->count();
        $physicalBooks = $this->books()->physical()->count();

        return [
            'total_books' => $totalBooks,
            'digital_books' => $digitalBooks,
            'physical_books' => $physicalBooks,
        ];
    }

    // Accesor para nombre display
    public function getDisplayNameAttribute(): string
    {
        return $this->native_name ?? $this->name;
    }

    // Verificar si tiene libros
    public function hasBooks(): bool
    {
        return $this->books()->exists();
    }
}
