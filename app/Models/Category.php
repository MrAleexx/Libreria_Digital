<?php
// app/Models/Category.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'sort_order',
        'is_active',
        'image',
        'meta_title',
        'meta_description'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relación padre
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Relación hijos
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // Relación con libros
    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'book_category');
    }

    // Scope para categorías activas
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope para categorías principales (sin padre)
    public function scopeMain($query)
    {
        return $query->whereNull('parent_id');
    }

    // Obtener categorías con sus hijos
    public function scopeWithChildren($query)
    {
        return $query->with([
            'children' => function ($query) {
                $query->active()->orderBy('sort_order');
            }
        ]);
    }
}
