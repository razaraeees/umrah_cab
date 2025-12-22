<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PickUpLocation extends Model
{
    use HasFactory; 
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

    public function dropOffLocation()
    {
        return $this->hasMany(DropLocation::class);
    }
}
