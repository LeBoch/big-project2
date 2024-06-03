<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bike extends Model
{
    // Association de notre model bike à la table bike station
    protected $table = 'bike_station';
}
