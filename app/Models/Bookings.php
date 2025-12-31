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

    public function scopeFilter($query, $filters)
    {
        if (!empty($filters['search'])) {
            $query->where('guest_name', 'like', '%' . $filters['search'] . '%')
                ->orWhere('guest_phone', 'like', '%' . $filters['search'] . '%')
                ->orWhereHas('vehicle', fn($q) => $q->where('vehicle_name', 'like', '%' . $filters['search'] . '%'))
                ->orWhereHas('pickupLocation', fn($q) => $q->where('pickup_location_name', 'like', '%' . $filters['search'] . '%'))
                ->orWhereHas('dropoffLocation', fn($q) => $q->where('dropoff_location_name', 'like', '%' . $filters['search'] . '%'));
        }

        if (!empty($filters['date_filter'])) {
            $today = now()->format('Y-m-d');
            $tomorrow = now()->addDay()->format('Y-m-d');
            $afterTomorrow = now()->addDays(2)->format('Y-m-d');
            $yesterday = now()->subDay()->format('Y-m-d');

            switch ($filters['date_filter']) {
                case 'today':
                    $query->whereDate('pickup_date', $today);
                    break;
                case 'tomorrow':
                    $query->whereDate('pickup_date', $tomorrow);
                    break;
                case 'after_tomorrow':
                    $query->whereDate('pickup_date', $afterTomorrow);
                    break;
                case 'yesterday':
                    $query->whereDate('pickup_date', $yesterday);
                    break;
            }
        }

        if (!empty($filters['start_date'])) {
            $query->whereDate('pickup_date', '>=', $filters['start_date']);
        }
        if (!empty($filters['end_date'])) {
            $query->whereDate('pickup_date', '<=', $filters['end_date']);
        }

        return $query;
    }
}
