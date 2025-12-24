<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalService extends Model
{
    use HasFactory;

    protected $fillable = [
        'services',
        'charges_type',
        'charge_value',
        'type',
        'status',
    ];

    protected $casts = [
        'charge_value' => 'decimal:2',
        'status' => 'integer',
    ];

    public function getStatusAttribute($value)
    {
        return $value ? 'Active' : 'Inactive';
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = $value === 'active' || $value === 1 ? 1 : 0;
    }
}
