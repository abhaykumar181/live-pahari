<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bookings;
use App\Models\Packages;
use App\Models\BookingOrder;
use App\Models\BookingsMeta;
use App\Models\Addons;
use App\Models\Properties;
use App\Models\Settings;
use App\Models\BookingsConfirmations;
use App\Models\Itineraries;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmationRequired;
use App\Mail\BookingNotification;
use carbon\carbon;


class BookingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
      //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Booking Order
     * 
     * @accept Integer|String|Date
     * @since 1.0.0
     * 
     * return response 
     */
    public function makeOrder(Request $request){
        try{
            $validateInput = [
                'packageId' => 'required',
                'name' => 'required|string',
                'email' => 'required',
                'phonenumber' => 'required',
                'guests' => 'required',
                'checkinDate' => 'required',
                'totalPrice' => 'required',
                'orderItems' => 'required',
            ];
            
            $request->validate($validateInput);

            $package = Packages::find($request->packageId);
            if(is_null($package)){
                return response()->json(['success'=>false, 'message'=>'Invalid Package Request.'], 404);
            }

            $response = DB::transaction(function() use ($request, $package) {
                $packageId = ( $request->packageId < 10 && $request->packageId > 0 )? '0'.$request->packageId : $request->packageId;
                $request->checkinDate = Carbon::parse($request->checkinDate)->format('Y-m-d');
                $trimcheckinDate = str_replace('-','', $request->checkinDate);
                $checkBookingDateCount = Bookings::where(['checkInDate'=>$request->checkinDate,"packageId" => $request->packageId])->count();
                $bookingCode = ($checkBookingDateCount < 1) ? "PHID".$packageId.$trimcheckinDate : "PHID".$packageId.$trimcheckinDate.'-'.$checkBookingDateCount; 
                $checkOutdate = date('Y-m-d', strtotime($request->checkinDate. ' + '.($package->days-1).' days'));
                $itineraries = Itineraries::where(['packageId' => $request->packageId])->get()->tojson();

                // Saving booking details.
                $booking = new Bookings;
                $booking->bookingCode = $bookingCode;
                $booking->packageId = $request->packageId;
                $booking->name = $request->name;
                $booking->email = $request->email;
                $booking->phone = $request->phonenumber;
                $booking->guests = $request->guests;
                $booking->checkInDate = $request->checkinDate;
                $booking->checkOutDate = $checkOutdate;
                $booking->details = $itineraries;
                $booking->status = "active";
                
                if($booking->save()){
                    // Saving booking orders.
                    $bookingOrder = new BookingOrder;
                    $bookingOrder->bookingId = $booking->id;
                    $bookingOrder->quantity = $request->guests;
                    $bookingOrder->price = $request->totalPrice;
                    $bookingOrder->status = "unpaid";

                    if($bookingOrder->save()){
                        // Saving bookings items
                        foreach($request->orderItems as $key => $item){
                            if($item['type'] == "property"){
                                $property = Properties::find($item['id']);
                                if($property->confirmationRequired == 1){
                                    $bookingConfirmation = new BookingsConfirmations;
                                    $bookingConfirmation->bookingId = $booking->id;
                                    $bookingConfirmation->propertyId = $item['id'];
                                    $bookingConfirmation->confirmation = 'pending';
                                    $bookingConfirmation->payment = 'pending';
                                    $bookingConfirmation->save();
                                    continue;
                                }
                            }

                            $BookingsMeta = new BookingsMeta;
                            $BookingsMeta->bookingId = $booking->id;
                            $BookingsMeta->orderId = $bookingOrder->id;
                            $BookingsMeta->objectType = $item['type'];
                            $BookingsMeta->objectId = $item['id'];
                            $BookingsMeta->basePrice = $package->price;
                            $BookingsMeta->priceType = "unit";
                        
                            if($item['type'] == 'addon'){
                                $addon = Addons::find($item['id']);
                                $BookingsMeta->basePrice = $addon->price;
                                $BookingsMeta->priceType = $addon->priceType;
                            }else if($item['type'] == 'property'){
                                $property = Properties::find($item['id']);
                                $BookingsMeta->basePrice = $property->price;
                                $BookingsMeta->priceType = $property->priceType;
                            }

                            if($BookingsMeta->priceType == 'unit'){
                                $BookingsMeta->totalPrice = $BookingsMeta->basePrice * $request->guests;
                            }else{
                                $BookingsMeta->totalPrice = $BookingsMeta->basePrice;
                            }
                            $BookingsMeta->save();
                        }
                        $data['data'] = [
                            "bookingId" => $booking->id,
                            "orderId" => $bookingOrder->id,
                            "orderStatus" =>  $bookingOrder->status
                        ];
                        return ['success' => true, 'message' => "Order created!", 'status_code' => 200 , $data];
                    }else{
                        return ['success'=>false, 'message'=>'Order Booking Failed.', 'status_code' => 404];
                    }
                }else{
                    return ['success'=>false, 'message'=>'Order Booking Failed.', 'status_code' => 404];
                }
            });

            $statusCode = $response['status_code'];
            unset($response['status_code']);
            return response()->json($response, $statusCode);

        }catch(\Illuminate\Database\QueryException $e){
            return response()->json('Internal Server Error.', 500);
        }
        
    }

    /**
     * Update order
     * 
     * @accept Integer|Enum
     * @since 1.0.0
     * 
     * return response
     */

     protected function updateOrder(Request $request){
        try{
            $validateInput = [
                'bookingId' => 'required',
                'orderId' => 'required',
                'orderStatus' => 'required',
            ];
            
            $request->validate($validateInput);
            
            $order = BookingOrder::find($request->orderId);
            if(is_null($order)){
                return response()->json(['success'=>false, 'message'=>'Invalid Order Request.'], 404);
            }
            $order->status = $request->orderStatus;
            $order->save();
            $bookingCount= BookingOrder::where('bookingId', $request->bookingId)->count();
            $booking = Bookings::find($request->bookingId);
            // get order count
            if($bookingCount == 1 && $request->orderStatus == "paid"){
                $pendingConfirmations = BookingsConfirmations::where('bookingId', $request->bookingId)->where('confirmation','pending')->get();
                // dd(BookingsConfirmations::where('bookingId',$request->bookingId)->where('confirmation','pending')->get());
                if(!is_null($pendingConfirmations)){
                    foreach($pendingConfirmations as $index => $confirmationItem){
                        // Send Confirmation email to owners
                        $property = Properties::find($confirmationItem->propertyId);
                        Mail::to($property->email)->send(new ConfirmationRequired($confirmationItem));
                    }
                }
                
                // TODO: Add booking Notification email with booking details
                $bookingOrderStatus = BookingOrder::find($request->orderId)->status;
                if($bookingOrderStatus == 'paid'){
                    Mail::to($booking->email)->send(new BookingNotification($booking));
                }
                
            }else{
                if($request->orderStatus == "paid"){
                    $orderItems = BookingsMeta::where(['bookingId' => $booking->id, "orderId" => $request->orderId])->get();
                    
                    foreach($orderItems as $item){
                        if($item->objectType == "property"){
                            $confirmationExist = BookingsConfirmations::where(["propertyId" => $item->objectId, "bookingId" => $request->bookingId])->update(['payment' => 'paid']);
                        }
                    }
                }
            }

            return response()->json(['success' => true , 'message' => 'Order Updated Successfully!'], 200);            

        }catch(\Illuminate\Database\QueryException $e){
            return response()->json('Internal Server Error.', 500);
        }
    }


    /**
     * Update order on the payment of property confirmation.
     * 
     * @since 1.0.0
     * 
     * @return redirection 
     */

    protected function updatePropertyOrder(Request $request){
        try{
            $validateInput = [
                'bookingId' => 'required',
                'totalPrice' => 'required',
                'orderItems' => 'required',
            ];
        
            $request->validate($validateInput);

            $response = DB::transaction(function() use ($request) {
                $booking = Bookings::find($request->bookingId);
                if(is_null($booking)){
                    return ['success'=> false, 'message'=>'Invalid Booking request.', 'status_code' => 404];
                }
                // Saving booking orders.
                $bookingOrder = new BookingOrder;
                $bookingOrder->bookingId = $booking->id;
                $bookingOrder->quantity = $booking->guests;
                $bookingOrder->price = $request->totalPrice;
                $bookingOrder->status = "unpaid";
                if($bookingOrder->save()){
                    // Saving bookings items
                    foreach($request->orderItems as $key => $item){
                        $property = Properties::find($item['id']);
                        if(is_null($property)){
                            return ['success'=> false, 'message'=>'Invalid Property ID.', 'status_code' => 404];
                        }

                        $propertyConfirmed = BookingsConfirmations::where(["propertyId" => $property->id, "bookingId" => $booking->id])->first();
                        
                        if(is_null($propertyConfirmed)){
                            return ['success'=> false, 'message'=>'Invalid Property ID.', 'status_code' => 404];
                        }

                        if($propertyConfirmed->confirmation != "confirmed"){
                            return ['success'=> false, 'message'=>'Request forbidden!.', 'status_code' => 403];
                        }

                        $BookingsMeta = BookingsMeta::where(['bookingId' => $booking->id, "objectType" => "property", "objectId" => $property->id])->first();

                        if(is_null($BookingsMeta)){
                            $BookingsMeta = new BookingsMeta;
                            $BookingsMeta->bookingId = $booking->id;
                        }
                        $BookingsMeta->orderId = $bookingOrder->id;
                        $BookingsMeta->objectType = $item['type'];
                        $BookingsMeta->objectId = $item['id'];
                        $BookingsMeta->basePrice = $property->price;
                        $BookingsMeta->priceType = $property->priceType;
                        if($BookingsMeta->priceType == 'unit'){
                            $BookingsMeta->totalPrice = $BookingsMeta->basePrice * $booking->guests;
                        }else{
                            $BookingsMeta->totalPrice = $BookingsMeta->basePrice;
                        }
                        $BookingsMeta->save();
                    }

                    $data['data'] = [
                        "bookingId" => $booking->id,
                        "orderId" => $bookingOrder->id,
                        "orderStatus" =>  $bookingOrder->status
                    ];

                    return ['success' => true, 'message' => "Order Created successfully.", 'status_code' => 200 , $data];
                }else{
                    return ['success'=> false, 'message'=>'Order Booking Failed.', 'status_code' => 404];
                }
            });

            $statusCode = $response['status_code'];
            unset($response['status_code']);
            return response()->json($response, $statusCode);

        }catch(\illuminate\database\QueryException $e){
            return redirect()->json('Internal Server Error.', 500);
        }
    }

    /**
     * Check availablility
     * 
     * @since 1.0.0
     * 
     * @return response
     */
    protected function checkAvailabilty(request $request){
        try{
            $validateInput = [
                'packageId' => 'required',
                'checkinDate' => 'required',
                'guests' => 'required',
            ];

            $request->validate($validateInput);

            $settings = Settings::first();
            $package = Packages::find($request->packageId);
            $booking = Bookings::where(['packageid' => $request->packageId])->get();
            $bookings = Bookings::where(['packageid' => $request->packageId , 'checkinDate' => $request->checkinDate])->get();
            $maxGuests = $settings->maxGuests;
            $packageDays = $package->days;
            $bookedPackagespace = $bookings->sum('guests');

            $checkoutDate = date('Y-m-d', strtotime(Carbon::parse($booking->first()->checkInDate)->format('Y-m-d'). ' + '.( $packageDays-1 ).' days'));
            if( $booking->count() > 0 ){
                if( $request->guests > $maxGuests ){
                    return response()->json(['success'=>false, 'message'=>'Guests limit exceeded.'], 404);
                }
                if( $bookedPackagespace + $request->guests > $maxGuests ){
                    return response()->json(['success'=>false, 'message'=>'Package not available for this date.(on space basis)'], 404);
                }

                $calculatedCheckoutdate = date('Y-m-d', strtotime($request->checkinDate. ' + '.( $packageDays-1 ).' days'));
                if($checkoutDate != $calculatedCheckoutdate || $checkoutDate < $calculatedCheckoutdate){
                    return response()->json(['success'=>false, 'message'=>'Package not available for this date.(on calculated checkout and date is less than first booking)'], 404);
                }
                /*if($request->checkinDate < $booking->first()->checkInDate){
                    return response()->json(['success'=>false, 'message'=>'Package not available for this date.'], 404);
                }*/
            }
            
        }catch(\Illuminate\Database\QueryException $e){
            return redirect()->json('Internal Server Error.', 500);
        }
    }
}
