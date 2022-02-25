<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Charger extends Model
{
    protected $collection = 'chargers';
    protected $guarded = [];
}
