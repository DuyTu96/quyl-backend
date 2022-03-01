<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class DeviceToken extends Model
{
    protected $collection = 'device_tokens';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
