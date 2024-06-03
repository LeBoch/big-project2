<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tram extends Model
{
    // Association de notre Model tram à notre
    protected $table = 'tram_stop';
}
