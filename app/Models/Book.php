<?php
// app/Models/Book.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        // INFORMACIÓN BÁSICA ESENCIAL
        'title',
        'isbn',
        'publisher_id',
        'language_code',
        'publication_year',
        'pages',

        // ARCHIVOS Y MULTIMEDIA
        'cover_image',
        'pdf_file',

        // CONTROL DE ACCESO Y TIPO
        'book_type',
        'access_level',
        'copyright_status',
        'license_type',
        'is_active',
        'downloadable',

        // DESTACADOS Y ESTADÍSTICAS (SOLO featured)
        'featured',
        'total_downloads',
        'total_views',

        // ESTADÍSTICAS FÍSICAS
        'total_physical_copies',
        'available_physical_copies',
        'total_loans',
    ];

    protected $casts = [
        'publication_year' => 'integer',
        'pages' => 'integer',
        'is_active' => 'boolean',
        'downloadable' => 'boolean',
        'featured' => 'boolean', // Solo featured, no is_featured_new
        'total_downloads' => 'integer',
        'total_views' => 'integer',
        'total_physical_copies' => 'integer',
        'available_physical_copies' => 'integer',
        'total_loans' => 'integer',
    ];

    // Relación con editorial
    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }

    // Relación con idioma
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'language_code', 'code');
    }

    // Relación con detalles opcionales
    public function details(): HasOne
    {
        return $this->hasOne(BookDetail::class);
    }

    // Relación con ejemplares físicos
    public function physicalCopies(): HasMany
    {
        return $this->hasMany(PhysicalCopy::class);
    }

    // Relación con reservas
    public function reservations(): HasMany
    {
        return $this->hasMany(BookReservation::class);
    }

    // Relación con préstamos
    public function loans(): HasManyThrough
    {
        return $this->hasManyThrough(
            BookLoan::class,          // Modelo destino
            PhysicalCopy::class,      // Modelo intermedio
            'book_id',                // Clave foránea en physical_copies
            'physical_copy_id',       // Clave foránea en book_loans
            'id',                     // Clave local en books
            'id'                      // Clave local en physical_copies
        );
    }

    // Relaciones existentes (mantener para compatibilidad)
    public function contributors(): HasMany
    {
        return $this->hasMany(BookContributor::class);
    }

    public function contents(): HasMany
    {
        return $this->hasMany(BookContent::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'book_category');
    }

    public function downloads(): HasMany
    {
        return $this->hasMany(UserDownload::class);
    }

    public function activeLoans()
    {
        return $this->loans()->where('status', 'active');
    }

    public function activeReservations()
    {
        return $this->reservations()
            ->whereIn('status', ['pending', 'ready_for_pickup']);
    }

    public function bookLoans()
    {
        return $this->hasMany(BookLoan::class);
    }

    // ACCESORES PARA DATOS OPCIONALES

    public function getDescriptionAttribute(): ?string
    {
        return $this->details?->description;
    }

    public function getEditionAttribute(): ?string
    {
        return $this->details?->edition;
    }

    public function getFileFormatAttribute(): ?string
    {
        return $this->details?->file_format;
    }

    public function getFileSizeAttribute(): ?string
    {
        return $this->details?->file_size;
    }

    public function getReadingAgeAttribute(): ?string
    {
        return $this->details?->reading_age;
    }

    public function getDepositoLegalAttribute(): ?string
    {
        return $this->details?->deposito_legal;
    }

    // MÉTODOS PARA GESTIÓN FÍSICA

    public function isAvailableForLoan(): bool
    {
        return $this->available_physical_copies > 0;
    }

    public function getAvailableCopiesCount(): int
    {
        return $this->physicalCopies()->where('status', 'available')->count();
    }

    public function getReservedCopiesCount(): int
    {
        return $this->physicalCopies()->where('status', 'reserved')->count();
    }

    public function getLoanedCopiesCount(): int
    {
        return $this->physicalCopies()->where('status', 'loaned')->count();
    }

    // MÉTODOS PARA ACTUALIZAR CONTADORES FÍSICOS
    public function updatePhysicalCounters(): void
    {
        $this->update([
            'total_physical_copies' => $this->physicalCopies()->count(),
            'available_physical_copies' => $this->physicalCopies()->where('status', 'available')->count(),
            'total_loans' => $this->loans()->count(),
        ]);
    }

    // MÉTODOS EXISTENTES (actualizados)

    public function getAllAuthorsAttribute(): string
    {
        $authors = $this->contributors()
            ->where('contributor_type', 'author')
            ->orderBy('sequence_number')
            ->pluck('full_name');

        return $authors->isNotEmpty() ? $authors->implode(', ') : 'Sin autor';
    }

    public function getMainAuthorAttribute(): ?string
    {
        $mainAuthor = $this->contributors()
            ->where('contributor_type', 'author')
            ->orderBy('sequence_number')
            ->first();

        return $mainAuthor ? $mainAuthor->full_name : 'Sin autor';
    }

    public function getEditorsAttribute(): string
    {
        $editors = $this->contributors()
            ->where('contributor_type', 'editor')
            ->orderBy('sequence_number')
            ->pluck('full_name');

        return $editors->isNotEmpty() ? $editors->implode(', ') : '';
    }

    public function addAuthor(string $name, int $sequence = 1): BookContributor
    {
        return $this->contributors()->create([
            'contributor_type' => 'author',
            'full_name' => $name,
            'sequence_number' => $sequence
        ]);
    }

    public function getContributorsByType(string $type)
    {
        return $this->contributors()
            ->where('contributor_type', $type)
            ->orderBy('sequence_number')
            ->get();
    }

    // Métodos para estadísticas de uso
    public function incrementViews(): void
    {
        $this->increment('total_views');
    }

    public function incrementDownloads(): void
    {
        $this->increment('total_downloads');
    }

    public function isAccessibleForUser($user = null): bool
    {
        if ($this->access_level === 'free') {
            return true;
        }

        if ($this->access_level === 'premium' && $user && $user->hasPremiumAccess()) {
            return true;
        }

        if ($this->access_level === 'institutional' && $user && $user->isInstitutional()) {
            return true;
        }

        return false;
    }

    // SCOPES

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeDownloadable($query)
    {
        return $query->where('downloadable', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeByAccessLevel($query, $level)
    {
        return $query->where('access_level', $level);
    }

    public function scopeMostDownloaded($query, $limit = 10)
    {
        return $query->orderBy('total_downloads', 'desc')->take($limit);
    }

    public function scopeMostViewed($query, $limit = 10)
    {
        return $query->orderBy('total_views', 'desc')->take($limit);
    }

    public function scopeNewArrivals($query, $limit = 10)
    {
        return $query->where('featured', true) // Usar featured en lugar de is_featured_new
            ->orderBy('created_at', 'desc')
            ->take($limit);
    }

    // Scopes para tipos de libros
    public function scopeDigital($query)
    {
        return $query->where('book_type', 'digital')->orWhere('book_type', 'both');
    }

    public function scopePhysical($query)
    {
        return $query->where('book_type', 'physical')->orWhere('book_type', 'both');
    }

    public function scopeByBookType($query, $type)
    {
        return $query->where('book_type', $type);
    }

    // Scopes existentes
    public function scopeByCategory($query, $categorySlug)
    {
        return $query->whereHas('categories', function ($query) use ($categorySlug) {
            $query->where('slug', $categorySlug)->where('is_active', true);
        });
    }

    public function getMainCategoriesAttribute()
    {
        return $this->categories()->whereNull('parent_id')->get();
    }

    public function syncCategories(array $categoryIds)
    {
        return $this->categories()->sync($categoryIds);
    }

    public function addCategory($categoryId)
    {
        return $this->categories()->attach($categoryId);
    }

    public function removeCategory($categoryId)
    {
        return $this->categories()->detach($categoryId);
    }

    public function getAllCategoriesAttribute()
    {
        return $this->categories()->with('parent')->get();
    }

    public function belongsToCategory($categorySlug): bool
    {
        return $this->categories()
            ->where('slug', $categorySlug)
            ->where('is_active', true)
            ->exists();
    }

    public function getUsageStatsAttribute(): array
    {
        return [
            'total_views' => $this->total_views,
            'total_downloads' => $this->total_downloads,
            'total_loans' => $this->total_loans,
            'download_ratio' => $this->total_views > 0
                ? round(($this->total_downloads / $this->total_views) * 100, 2)
                : 0,
            'availability_ratio' => $this->total_physical_copies > 0
                ? round(($this->available_physical_copies / $this->total_physical_copies) * 100, 2)
                : 0,
        ];
    }

    // Método para obtener información completa del libro
    public function getFullInfoAttribute(): array
    {
        return [
            'basic' => [
                'title' => $this->title,
                'isbn' => $this->isbn,
                'publisher' => $this->publisher?->name,
                'language' => $this->language?->native_name,
                'publication_year' => $this->publication_year,
                'pages' => $this->pages,
            ],
            'access' => [
                'book_type' => $this->book_type,
                'access_level' => $this->access_level,
                'copyright_status' => $this->copyright_status,
                'is_active' => $this->is_active,
            ],
            'stats' => $this->usage_stats,
            'physical' => [
                'total_copies' => $this->total_physical_copies,
                'available_copies' => $this->available_physical_copies,
                'is_available' => $this->isAvailableForLoan(),
            ]
        ];
    }
}
