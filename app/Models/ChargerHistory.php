<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class ChargerHistory extends Model
{
    protected $collection = 'charger_history';
    protected $guarded = [];
}
