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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmationRequired;
use App\Mail\BookingNotification;


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
        // Update booking confirmation when confirmation request will be accepted by property owner.
        $pendingBookings = BookingsConfirmations::where('bookingId', $id)->where('confirmation','pending')->get();
        if(!is_null($pendingBookings)){
            foreach($pendingBookings as $index => $bookings){
                $bookings->confirmation = "confirmed";
                $bookings->save();
            }
        }else{
            return response()->json(['error' => true , 'message' => 'No Booking confirmations are available.']);
        }
        // If payment is made successful, then we will add a new order in Orders Table.
        $findbookingOrder = BookingOrder::where('bookingId',$id)->get();
        $confirmedBookings = BookingsConfirmations::where('bookingId', $id)->where('confirmation','confirmed')->get();
        // dd($confirmedBookings);
        foreach($confirmedBookings as $index => $confirmedBooking){
            $property = Properties::find($confirmedBooking->propertyId);
            $bookingOrder = new BookingOrder;
            $bookingOrder->bookingId = $findbookingOrder[$index]->bookingId;
            $bookingOrder->quantity = Bookings::find($id)->guests;
            $bookingOrder->price = $property->price;
            $bookingOrder->status = "paid";
            if($bookingOrder->save()){
                $BookingsMeta = new BookingsMeta;
                $BookingsMeta->bookingId = $bookingOrder->bookingId;
                $BookingsMeta->orderId = $bookingOrder->id;
                $BookingsMeta->objectType = "property";
                $BookingsMeta->objectId = $property->id;
                $BookingsMeta->basePrice = $property->price;
                $BookingsMeta->priceType = $property->priceType;
                if($BookingsMeta->priceType == 'unit'){
                    $BookingsMeta->totalPrice = $BookingsMeta->basePrice * Bookings::find($id)->guests;
                }else{
                    $BookingsMeta->totalPrice = $BookingsMeta->basePrice;
                }
                $BookingsMeta->save();
            }
        }
        return response()->json(['success' => true , 'message' => 'Booking Successful!.']);

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
                // 'orderItems' => 'required',
            ];
            
            $request->validate($validateInput);
            
            if($request->guests > Settings::pluck('maxGuests')->first()){
                return response()->json(['error'=>true, 'message'=>'Guests limit exceeded. Can\'t book order.'], 404);
            }

            $package = Packages::find($request->packageId);
            if(is_null($package)){
                return response()->json(['error'=>true, 'message'=>'Invalid Package Request.'], 404);
            }            

            $response = DB::transaction(function() use ($request, $package) {
                $packageId = ( $request->packageId < 10 && $request->packageId > 0 )? '0'.$request->packageId : $request->packageId;
                $trimcheckinDate = str_replace('-','',$request->checkinDate);
                $checkBookingDateCount = Bookings::where(['checkInDate'=>$request->checkinDate])->count();
                $bookingCode = ($checkBookingDateCount < 1) ? "PHID".$packageId.$trimcheckinDate : "PHID".$packageId.$trimcheckinDate.'-'.$checkBookingDateCount; 
                $checkOutdate = date('Y-m-d', strtotime($request->checkinDate. ' + '.$package->days.' days'));
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
                $booking->status = "active";
                
                if($booking->save()){
                    // Saving booking orders.
                    $bookingOrder = new BookingOrder;
                    $bookingOrder->bookingId = $booking->id;
                    $bookingOrder->quantity = $request->guests;
                    $bookingOrder->price = $request->totalPrice;
                    $bookingOrder->status = "unpaid";

                    if($bookingOrder->save()){
                        $orderItems = [
                            ["type" => 'package', "id" => 1],
                            ["type" => 'property', "id" => 1],
                            ["type" => 'property', "id" => 2],
                            ["type" => 'addon', "id" => 1],
                            ["type" => 'addon', "id" => 2],
                        ];
                        // Saving bookings items                        
                        foreach($orderItems as $key => $item){
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
                        return ['error'=>true, 'message'=>'Order Booking Failed.', 'status_code' => 404];
                    }
                }else{
                    return ['error'=>true, 'message'=>'Order Booking Failed.', 'status_code' => 404];
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
                return response()->json(['error'=>true, 'message'=>'Invalid Order Request.'], 404);
            }
            $order->status = $request->orderStatus;
            $order->save();
            $bookingCount= BookingOrder::where('bookingId', $request->bookingId)->count();
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
                    $booking = Bookings::find($request->bookingId);
                    Mail::to($booking->email)->send(new BookingNotification($booking));
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
            $orderItems = [
                ["type" => 'property', "id" => 1],
                ["type" => 'property', "id" => 2],
            ];

            $validateInput = [
                'bookingId' => 'required',
                'totalPrice' => 'required',
                // 'orderItems' => 'required',
            ];

            // dd($request->json());
        
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
                    foreach($orderItems as $key => $item){
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

            /*
            foreach($orderItems as $key => $item){

                $property = Properties::find($item['id']);
                if($item['type'] == "property"){
                    $property = Properties::find($item['id']);
                    if($property->confirmationRequired == 1){
                        // Creating new order of properties
                        $bookingOrder = new BookingOrder;
                        $bookingOrder->bookingId = $request->bookingId; 
                        $bookingOrder->quantity = $booking->guests;
                        $bookingOrder->price = $property->price;
                        if($property->priceType == "fixed"){
                            $bookingOrder->price = $property->price;
                        }elseif($property->priceType == "unit"){
                            $bookingOrder->price = $property->price * $booking->guests;
                        }
                        $bookingOrder->status = "paid";
                        if($bookingOrder->save()){
                            // Saving property in bookings meta
                            $bookingmeta = new BookingsMeta;
                            $bookingmeta->bookingId = $request->bookingId;
                            $bookingmeta->orderId = $bookingOrder->id;
                            $bookingmeta->objectType = "property";
                            $bookingmeta->objectId = $item['id'];
                            $bookingmeta->basePrice = $property->price;
                            $bookingmeta->priceType = $property->priceType;
                            $bookingmeta->totalPrice = $request->totalPrice;
                            $bookingmeta->save();
                        }
                    }
                }

            }
            */
            $data['data'] = [
                "success" => true,
                "message" => "Order created successfully!"
            ];

            return response()->json($data, 200);

        }catch(\illuminate\database\QueryException $e){
            return redirect()->json(['error' => true, 'message' => 'Internal Server Error.'], 500);
        }
    }
}
