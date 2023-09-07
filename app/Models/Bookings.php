<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Packages;
use Carbon\Carbon;

class Bookings extends Model
{
    use HasFactory;
    protected $table = "pahhos_bookings";

    public function getCreatedAtAttribute($date){
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d-m-y');
    }

}
