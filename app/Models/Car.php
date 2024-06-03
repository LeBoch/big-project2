<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    // Association de notre Model Car à notre table car parking
    protected $table = 'car_parking';
}
