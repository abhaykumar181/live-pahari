<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\BookingsConfirmations;
use App\Models\Properties;
use App\Models\Bookings;
use App\Models\BookingOrder;
use App\Mail\ConfirmationAccepted;
use App\Mail\ConfirmationRejected;

class BookingController extends Controller
{
    /**
     * Display confirmation required page for Property hosts.
     * 
     * @accept Integer
     * @since 1.0.0
     * 
     * @return html 
     */
    protected function viewDetails($confirmationId){
        $data['confirmationId'] = $confirmationId;
        $data['confirmationItem'] = BookingsConfirmations::whereRaw(" md5(id)='".$confirmationId."' ")->first();
        $data['property'] = Properties::find($data['confirmationItem']->propertyId);
        $data['booking'] = Bookings::find($data['confirmationItem']->bookingId);
        return view('frontend.bookings.booking-confirmation', $data);
    }

    /**
     * Send mail on property confirmation
     * 
     * @since 1.0.0
     * 
     * @return redirection 
     */
    protected function propertyActions(Request $request){
        try{
            $bookingConfirmation = BookingsConfirmations::find($request->post('id'));
            if($request->confirm){
                $bookingConfirmation->confirmation = "confirmed";
            }elseif($request->reject){
                $bookingConfirmation->confirmation = "rejected";
            }

            if($bookingConfirmation->save()){
                $booking = Bookings::find($bookingConfirmation->bookingId);
                if($request->confirm){
                    Mail::to($booking->email)->send(new ConfirmationAccepted($bookingConfirmation));
                    return redirect()->back()->with('message','Customer confirmation request has been accepted.');
                }elseif($request->reject){
                    Mail::to($booking->email)->send(new ConfirmationRejected($bookingConfirmation));
                    return redirect()->back()->with('message','Customer confirmation request has been rejected.');
                }
            }
        }catch(\Illuminate\database\QueryException $e){
            return redirect()->back()->with('error','Server Error. Please try again.');
        }
    }
}
