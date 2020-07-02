<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['building_id', 'floor_id', 'room_number', 'status'];
}
