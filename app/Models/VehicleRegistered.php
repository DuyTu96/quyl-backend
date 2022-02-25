<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class VehicleRegistered extends Model
{
    protected $collection = 'vehicles_registered';
    protected $guarded = [];
}
