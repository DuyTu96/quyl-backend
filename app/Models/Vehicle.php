<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Vehicle extends Model
{
    protected $collection = 'vehicles';
    protected $guarded = [];
    protected $primaryKey = '_id';
}
