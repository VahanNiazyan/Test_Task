<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table = 'regions';
    protected $fillable = [
        'name',
        'time',
        'latitude',
        'longitude',
        'temp',
        'pressure',
        'humidity',
        'temp_min',
        'temp_max',
    ];
}
