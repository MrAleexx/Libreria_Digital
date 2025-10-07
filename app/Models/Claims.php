<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Claims extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'dni',
        'email',
        'tipo_reclamo',
        'subject',
        'description'
    ];
}
