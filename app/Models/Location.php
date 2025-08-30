<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'province',
        'city',
        'district',
        'village',
        'latitude',
        'longitude'
    ];
    public $timestamps = false;
}
