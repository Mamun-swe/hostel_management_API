<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    protected $fillable = [
        'student_id',
        'name',
        'phone_number',
        'relation',
        'check_in_date',
        'check_out_date',
        'daily_amount'
    ];
}
