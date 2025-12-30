<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarDetails extends Model
{
    protected $fillable = [
        'name',
        'model_variant',
        'color',
        'door',
        'bag_capacity',
        'registration_number',
        'year',
        'seating_capacity',
        'fuel_type',
        'car_type',
        'air_condition',
    ];
    protected $casts = [
        'air_condition' => 'boolean',
    ];

    

    public function assignedDriver()
    {
        return $this->hasOne(Driver::class, 'car_id');
    }
}
