<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    protected $fillable = [
        'guest_name',
        'guest_phone',
        'guest_whatsapp',
        'pickup_location_id',
        'pickup_location_name',
        'pickup_hotel_name',
        'dropoff_location_id',
        'dropoff_location_name',
        'dropoff_hotel_name',
        'vehicle_id',
        'vehicle_name',
        'no_of_children',
        'no_of_infants',
        'no_of_adults',
        'total_passengers',
        'pickup_date',
        'pickup_time',
        'airline_name',
        'flight_number',
        'flight_details',
        'arrival_departure_date',
        'arrival_departure_time',
        'extra_information',
        'booking_status',
        'total_amount',
        'discount_amount',
        'price',
        'recived_paymnet',
    ];


    public function additionalServices()
    {
        return $this->belongsToMany(
            AdditionalService::class,
            'booking_additional_service',
            'booking_id',                 
            'additional_service_id'       
        )->withPivot('amount')->withTimestamps();
    }



    public function pickupLocation()
    {
        return $this->belongsTo(PickUpLocation::class, 'pickup_location_id');
    }

    public function dropoffLocation()
    {
        return $this->belongsTo(DropLocation::class, 'dropoff_location_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(CarDetails::class, 'vehicle_id');
    }
}
