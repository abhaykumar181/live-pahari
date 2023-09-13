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
        if(!$data['confirmationItem']){
            abort(404);
        }else{
            $data['property'] = Properties::find($data['confirmationItem']->propertyId);
            $data['booking'] = Bookings::find($data['confirmationItem']->bookingId);   
            return view('frontend.bookings.booking-confirmation', $data);
        }
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
                    return redirect()->route('bookings.confirmationStatus')->with('message','Customer confirmation request has been accepted.');
                    Mail::to($booking->email)->send(new ConfirmationAccepted($bookingConfirmation));
                }elseif($request->reject){
                    return redirect()->route('bookings.confirmationStatus')->with('message','Customer confirmation request has been rejected.');
                    Mail::to($booking->email)->send(new ConfirmationRejected($bookingConfirmation));
                }
            }
        }catch(\Illuminate\database\QueryException $e){
            return redirect()->back()->with('error','Server Error. Please try again.');
        }
    }

    /**
     * Display Confirmation Status  
     * 
     * @since 1.0.0
     * 
     * @return html
     */

     protected function confirmationStatus(){
        return view('frontend.bookings.confirmation-message');
     }
}
