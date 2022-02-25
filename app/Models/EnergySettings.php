<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class EnergySettings extends Model
{
    use HasFactory;
    protected $collection = 'energy_settings';
    protected $guarded = [];
}
