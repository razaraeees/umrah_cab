<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DropLocation extends Model

{ 
    use HasFactory;
    
    protected $fillable = [
        'pick_up_location_id',
        'drop_off_location',
        'type',
        'status',
    ];
    public function pickUpLocation()
    {
    return $this->belongsTo(PickUpLocation::class);
    }
}
