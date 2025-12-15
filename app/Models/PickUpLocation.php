<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PickUpLocation extends Model
{
    protected $table = "pick_up_locations";

    protected $fillable = [
        'pickup_location',
        'type',
        'status'
    ];

    // public $timestamps = false;

    protected $casts = [
        'status' => 'string',
    ];
}
