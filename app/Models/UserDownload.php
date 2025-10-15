<?php
// app/Models/UserDownload.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDownload extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'downloaded_at',
        'ip_address',
    ];

    protected function casts(): array
    {
        return [
            'downloaded_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // Scope para descargas de hoy
    public function scopeToday($query)
    {
        return $query->whereDate('downloaded_at', today());
    }

    // Scope para descargas recientes
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('downloaded_at', '>=', now()->subDays($days));
    }

    // Scope para descargas de un usuario específico
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByBook($query, $bookId)
    {
        return $query->where('book_id', $bookId);
    }
}
