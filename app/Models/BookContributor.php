<?php
// app/Models/BookContributor.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookContributor extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'contributor_type',
        'full_name',
        'email',
        'sequence_number',
        'biographical_note'
    ];

    protected $casts = [
        'sequence_number' => 'integer'
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
