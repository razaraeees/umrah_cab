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
        'availability',       
        'car_id',             
        'rc_copy',            
        'insurance_copy',     
        'driving_license',    
        'dl_expiry',          
    ];
}
