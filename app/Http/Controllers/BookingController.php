<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingController extends Controller
{    
    protected function viewDetails($confirmationId){
        $confirmationItem = BookingsConfirmations::whereRaw( "md5(id)='".$confirmationId."' ")->first();
        return view('frontend.bookingConfirmation.booking-confirmation');
    }

}
