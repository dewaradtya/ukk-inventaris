<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'condition',
        'amount',
        'register_date',
        'code',
        'id_type',
        'id_room',
        'id_user',
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class, 'id_type');
    }
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'id_room');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function decreaseStock($amount)
    {
        $this->amount -= $amount;
        $this->save();
    }
}
