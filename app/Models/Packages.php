<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Thumbnails;
use App\Models\Itineraries;

class Packages extends Model
{
    use HasFactory;
    protected $table = "pahhos_packages";

    /**
     * Package Relation with Gallery
     */
    public function gallery(){
        return $this->hasMany(Thumbnails::class, 'packageId', 'id');
    }

    /**
     * Package Relation with Itineraries
     */
     public function itineraries(){
        return $this->hasMany(Itineraries::class, 'packageId', 'id');
    }


}
