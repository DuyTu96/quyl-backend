<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
class Payment extends Model
{
    protected $collection = 'transactions';
    protected $guarded = [];
}
