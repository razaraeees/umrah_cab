<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdditionalServices extends Model
{
    protected $fillable = ['services', 'charges_type', 'charge_value', 'type', 'status'];
}
