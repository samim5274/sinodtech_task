<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'purchase_count',
        'last_purchase_at',
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function assignment()
    {
        return $this->hasOne(CustomerAssignment::class);
    }
}
