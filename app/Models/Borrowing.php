<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Borrowing extends Model
{
    use HasFactory;

    protected $fillable = [
        'borrow_date',
        'return_date',
        'loan_status',
        'actual_return_date',
        'id_employee'
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'id_employee');
    }


    public function loanDetails()
    {
        return $this->hasMany(LoanDetail::class, 'id_borrowing');
    }
}
