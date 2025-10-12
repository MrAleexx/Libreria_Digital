<?php
// app/Models/Book.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

        // Información de Lectura
        'reading_age',
        'publication_url',

        // Archivos
        'image',
        'pdf_file',

        // Estados
        'is_new',
        'active',
        'downloadable',

        // ✅ NUEVO: Campos de Biblioteca
        'total_downloads',
        'total_views',
        'featured',
        'access_level',

        'published_at'
    ];

    protected $casts = [
        'publication' => 'date',
        'published_at' => 'datetime',
        'pages' => 'integer',
        'is_new' => 'boolean',
        'active' => 'boolean',
        'downloadable' => 'boolean',

        // ✅ NUEVO: Casts para biblioteca
        'total_downloads' => 'integer',
        'total_views' => 'integer',
        'featured' => 'boolean',
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

    // Relación con categorías
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'book_category');
    }

    // Relación con descargas de usuarios
    public function downloads()
    {
        return $this->hasMany(UserDownload::class);
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

    // Obtener autor principal
    public function getMainAuthorAttribute(): ?string
    {
        $mainAuthor = $this->contributors()
            ->where('contributor_type', 'author')
            ->orderBy('sequence_number')
            ->first();

        return $mainAuthor ? $mainAuthor->full_name : 'Sin autor';
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

    // ✅ NUEVO: Incrementar contador de vistas
    public function incrementViews(): void
    {
        $this->increment('total_views');
    }

    // ✅ NUEVO: Incrementar contador de descargas
    public function incrementDownloads(): void
    {
        $this->increment('total_downloads');
    }

    // ✅ NUEVO: Verificar si es accesible para un usuario
    public function isAccessibleForUser($user = null): bool
    {
        if ($this->access_level === 'free') {
            return true;
        }

        if ($this->access_level === 'premium' && $user && $user->hasPremiumAccess()) {
            return true;
        }

        if ($this->access_level === 'institutional' && $user && $user->hasInstitutionalAccess()) {
            return true;
        }

        return false;
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

    // ✅ NUEVO: Scope para libros destacados
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    // ✅ NUEVO: Scope por nivel de acceso
    public function scopeByAccessLevel($query, $level)
    {
        return $query->where('access_level', $level);
    }

    // ✅ NUEVO: Scope para libros más descargados
    public function scopeMostDownloaded($query, $limit = 10)
    {
        return $query->orderBy('total_downloads', 'desc')->take($limit);
    }

    // ✅ NUEVO: Scope para libros más vistos
    public function scopeMostViewed($query, $limit = 10)
    {
        return $query->orderBy('total_views', 'desc')->take($limit);
    }

    // ✅ NUEVO: Scope para libros nuevos
    public function scopeNewArrivals($query, $limit = 10)
    {
        return $query->where('is_new', true)
            ->orderBy('created_at', 'desc')
            ->take($limit);
    }

    // Scope para buscar por categoría
    public function scopeByCategory($query, $categorySlug)
    {
        return $query->whereHas('categories', function ($query) use ($categorySlug) {
            $query->where('slug', $categorySlug)->active();
        });
    }

    // Obtener categorías principales del libro
    public function getMainCategoriesAttribute()
    {
        return $this->categories()->whereNull('parent_id')->get();
    }

    // Método para sincronizar categorías
    public function syncCategories(array $categoryIds)
    {
        return $this->categories()->sync($categoryIds);
    }

    // Método para agregar una categoría
    public function addCategory($categoryId)
    {
        return $this->categories()->attach($categoryId);
    }

    // Método para remover una categoría
    public function removeCategory($categoryId)
    {
        return $this->categories()->detach($categoryId);
    }

    // Obtener todas las categorías incluyendo subcategorías
    public function getAllCategoriesAttribute()
    {
        return $this->categories()->with('parent')->get();
    }

    // Verificar si pertenece a una categoría específica
    public function belongsToCategory($categorySlug): bool
    {
        return $this->categories()
            ->where('slug', $categorySlug)
            ->active()
            ->exists();
    }

    // ✅ NUEVO: Obtener estadísticas de uso
    public function getUsageStatsAttribute(): array
    {
        return [
            'total_views' => $this->total_views,
            'total_downloads' => $this->total_downloads,
            'download_ratio' => $this->total_views > 0
                ? round(($this->total_downloads / $this->total_views) * 100, 2)
                : 0,
        ];
    }
}
