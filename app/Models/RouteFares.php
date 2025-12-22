<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RouteFares extends Model
{
    protected $fillable = [
        'pickup_id',
        'dropoff_id', 
        'vehicle_id',
        'amount',
        'start_date',
        'end_date',
        'status'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    public function pickupLocation()
    {
        return $this->belongsTo(PickUpLocation::class, 'pickup_id');
    }

    public function dropoffLocation()
    {
        return $this->belongsTo(DropLocation::class, 'dropoff_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(CarDetails::class, 'vehicle_id');
    }
}
