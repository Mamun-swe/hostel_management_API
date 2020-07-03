<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'room_id', 
        'admin_id', 
        'name', 
        'own_mobile_number', 
        'parents_mobile_number', 
        'admission_date', 
        'status'
    ];
}
