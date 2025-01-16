<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Officer extends Model
{
    use HasFactory;

    protected $fillable = [
        'username',
        'password',
        'name',
        'id_level',
    ];

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class, 'id_level');
    }
}
