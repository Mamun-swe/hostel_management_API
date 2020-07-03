<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'student_id',
        'admin_id',
        'amount', 
        'payment_type', 
        'reference'
    ];
}
