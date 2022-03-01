<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Customers extends Model
{
    protected $collection = 'users';
    protected $guarded = [];

    public function deviceTokens()
    {
        return $this->hasMany(DeviceToken::class);
    }
}