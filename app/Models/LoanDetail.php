<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoanDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_inventories',
        'id_borrowing',
        'amount',
    ];

    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class, 'id_inventories');
    }

    public function borrowing(): BelongsTo
    {
        return $this->belongsTo(Borrowing::class, 'id_borrowing');
    }
}
