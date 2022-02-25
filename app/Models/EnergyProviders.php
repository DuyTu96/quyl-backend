<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class EnergyProviders extends Model
{
    use HasFactory;
    protected $primaryKey = '_id';
    protected $collection = 'energy_providers';
    protected $guarded = [];
}
