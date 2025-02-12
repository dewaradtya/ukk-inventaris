<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fine extends Model
{
    use HasFactory;

    protected $fillable = [
        'borrowing_id',
        'fine_amount',
        'paid_amount',
        'payment_proof',
        'status',
    ];

    public function borrowing(): BelongsTo
    {
        return $this->belongsTo(Borrowing::class);
    }

    public function getRemainingAmountAttribute()
    {
        return $this->fine_amount - $this->paid_amount;
    }
}
