<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Locations;

class LocationRelationship extends Model
{
    use HasFactory;
    protected $table = "pahhos_location_relationship";
}
