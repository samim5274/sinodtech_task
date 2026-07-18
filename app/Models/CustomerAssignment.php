<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'employee_id',
        'assigned_at',
        'remarks',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
