<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Packages;

class Bookings extends Model
{
    use HasFactory;
    protected $table = "pahhos_bookings";
}
