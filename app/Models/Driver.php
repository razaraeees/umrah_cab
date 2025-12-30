<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = [
        'name',               
        'phone',              
        'email',              
        'status',                   
        'car_id',             
        'rc_copy',            
        'insurance_copy',     
        'driving_license',    
        'dl_expiry',
        'car_image',          
        'driver_image',       
    ];

    public function carDetails()
    {
        return $this->belongsTo(CarDetails::class, 'car_id');
    }

    public function bookings()
    {
        return $this->hasManyThrough(Bookings::class, CarDetails::class, 'id', 'vehicle_id', 'car_id', 'id');
    }
}
