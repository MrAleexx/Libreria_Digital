<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Publisher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'city',
        'country',
        'website',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relación con libros
    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }

    // Scope para editoriales activas
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Obtener estadísticas de la editorial
    public function getStatsAttribute(): array
    {
        $totalBooks = $this->books()->count();
        $digitalBooks = $this->books()->digital()->count();
        $physicalBooks = $this->books()->physical()->count();

        return [
            'total_books' => $totalBooks,
            'digital_books' => $digitalBooks,
            'physical_books' => $physicalBooks,
            'hybrid_books' => $this->books()->where('book_type', 'both')->count(),
        ];
    }

    // Verificar si tiene libros
    public function hasBooks(): bool
    {
        return $this->books()->exists();
    }

    // Obtener libros destacados de la editorial
    public function featuredBooks($limit = 5)
    {
        return $this->books()
            ->with(['details', 'language'])
            ->featured()
            ->active()
            ->limit($limit)
            ->get();
    }
}
