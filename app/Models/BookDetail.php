<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'description',
        'edition',
        'file_format',
        'file_size',
        'reading_age',
        'deposito_legal',
        'restrictions',
        'notes',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relación con el libro
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    // Accesor para mostrar la edición formateada
    public function getFormattedEditionAttribute(): string
    {
        if (!$this->edition) {
            return '1ra Edición';
        }

        $edition = strtolower($this->edition);
        if (str_contains($edition, '1') || str_contains($edition, 'primera')) {
            return '1ra Edición';
        } elseif (str_contains($edition, '2') || str_contains($edition, 'segunda')) {
            return '2da Edición';
        } elseif (str_contains($edition, '3') || str_contains($edition, 'tercera')) {
            return '3ra Edición';
        }

        return $this->edition;
    }

    // Accesor para el formato de archivo
    public function getFormattedFileFormatAttribute(): string
    {
        return strtoupper($this->file_format ?? 'PDF');
    }

    // Scope para libros con descripción
    public function scopeWithDescription($query)
    {
        return $query->whereNotNull('description')->where('description', '!=', '');
    }
}
