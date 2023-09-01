<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookingsConfirmations;
use App\Models\Properties;
use App\Models\Bookings;
use App\Models\BookingOrder;

class BookingController extends Controller
{    
    protected function viewDetails($confirmationId){
        $data['confirmationId'] = $confirmationId;
        $data['confirmationItem'] = BookingsConfirmations::whereRaw(" md5(id)='".$confirmationId."' ")->first();
        $data['property'] = Properties::find($data['confirmationItem']->propertyId);
        $data['booking'] = Bookings::find($data['confirmationItem']->bookingId);
        return view('frontend.bookings.booking-confirmation', $data);
    }

    protected function confirmProperty(Request $request){
        $bookingConfirmation = BookingsConfirmations::find($request->post('id'));
        $bookingConfirmation->confirmation = "confirmed";
        if($bookingConfirmation){

        }
        // if($bookingConfirmation->save()){
        //     $query = BookingOrder::find($bookingConfirmation->bookingId);
        //     $property = Properties::find($bookingConfirmation->propertyId);
        //     $guests = Bookings::find($bookingConfirmation->bookingId)->guests;

        //     $order = new BookingOrder;
        //     $order->bookingId = $bookingConfirmation->bookingId;
        //     $order->quantity = $query->quantity;
        //     if($property->priceType == "unit"){
        //         $order->price = $property->price * $guests;
        //     }elseif($property->priceType == "fixed"){
        //         $order->price = $property->price;
        //     }
        //     $order->status = "unpaid";
        //     if($order->save()){
        //         $bookingsMeta = new BookingsMeta;
        //         $bookingsMeta->bookingId = $bookingConfirmation->bookingId;
        //         $bookingsMeta->orderId = $order->id;
        //         $bookingsMeta->objectType = "property";
        //         $bookingsMeta->objectId = $bookingConfirmation->propertyId;
        //     }
        // }

    }

}
