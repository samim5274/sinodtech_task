<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'transaction_no',
        'amount',
        'payment_method',
        'payment_status',
        'paid_at',
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
