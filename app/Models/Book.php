<?php
// app/Models/Book.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        // Información Básica
        'title',
        'description',

        // Identificadores
        'isbn',
        'isbn13',
        'deposito_legal',

        // Información Editorial
        'publisher',
        'publisher_address',
        'publisher_email',
        'publisher_city',

        // Detalles Técnicos
        'language',
        'pages',
        'publication',
        'edition',
        'file_format',
        'file_size',

        // Información Comercial
        'price',
        'is_free',
        'reading_age',
        'publication_url',

        // Archivos
        'image',
        'pdf_file',

        // Estados
        'is_new',
        'active',
        'downloadable',
        'pre_order',
        'published_at'
    ];

    protected $casts = [
        'publication' => 'date',
        'published_at' => 'datetime',
        'price' => 'decimal:2',
        'is_free' => 'boolean',
        'pages' => 'integer',
        'is_new' => 'boolean',
        'active' => 'boolean',
        'downloadable' => 'boolean',
        'pre_order' => 'boolean',

    ];

    // Relación con contribuidores
    public function contributors(): HasMany
    {
        return $this->hasMany(BookContributor::class);
    }

    // Relación con contenido/índice
    public function contents(): HasMany
    {
        return $this->hasMany(BookContent::class);
    }

    // Obtener todos los autores
    public function getAllAuthorsAttribute(): string
    {
        $authors = $this->contributors()
            ->where('contributor_type', 'author')
            ->orderBy('sequence_number')
            ->pluck('full_name');

        return $authors->isNotEmpty() ? $authors->implode(', ') : 'Sin autor';
    }

    // Obtener autor principal (ÚNICA VERSIÓN)
    public function getMainAuthorAttribute(): ?string
    {
        $mainAuthor = $this->contributors()
            ->where('contributor_type', 'author')
            ->orderBy('sequence_number')
            ->first();

        return $mainAuthor?->full_name;
    }

    // Obtener editores
    public function getEditorsAttribute(): string
    {
        $editors = $this->contributors()
            ->where('contributor_type', 'editor')
            ->orderBy('sequence_number')
            ->pluck('full_name');

        return $editors->isNotEmpty() ? $editors->implode(', ') : '';
    }

    // Método para agregar autores fácilmente
    public function addAuthor(string $name, int $sequence = 1): BookContributor
    {
        return $this->contributors()->create([
            'contributor_type' => 'author',
            'full_name' => $name,
            'sequence_number' => $sequence
        ]);
    }

    // Método para obtener contribuidores por tipo
    public function getContributorsByType(string $type)
    {
        return $this->contributors()
            ->where('contributor_type', $type)
            ->orderBy('sequence_number')
            ->get();
    }

    // Scope para libros activos
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    // Scope para libros descargables
    public function scopeDownloadable($query)
    {
        return $query->where('downloadable', true);
    }

    // Scope para libros gratuitos
    public function scopeFree($query)
    {
        return $query->where('is_free', true);
    }

    // Scope para libros pagados
    public function scopePaid($query)
    {
        return $query->where('is_free', false);
    }
}
