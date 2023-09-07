<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bookings;
use App\Models\BookingsMeta;
use App\Models\BookingsConfirmations;

class BookingsController extends Controller
{
    /**
     * Shows bookings listing.
     * 
     * @since 1.0.0
     * 
     * @return html
     */
    protected function index(){
        try{
            $bookings = Bookings::all();
            return view('backend.bookings.index', compact('bookings'));
        }catch(\Illuminate\Database\QueryException $e){
            return redirect()->back()->with('error', 'Failed to open bookings.');
        }
    }

    /**
     * Display Booking Details.
     * 
     * @since 1.0.0
     * 
     * @return html
     */
    protected function viewDetails($bookingId=''){
        try{
            $data['booking'] = Bookings::find($bookingId);
            $data['orderItems'] = BookingsMeta::where(['bookingId' => $bookingId])->get();
            $data['propertyDetails'] = BookingsConfirmations::where('bookingId' ,'=', $bookingId)->where('confirmation' ,'!=', 'confirmed')->get();
            return view('backend.bookings.view-details', $data);
        }catch(\Illuminate\Database\QueryException $e){
            return redirect()->back()->with('error', 'Failed to view bookings.');
        }
    }

}
