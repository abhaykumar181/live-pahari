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
use Illuminate\Support\Facades\DB;


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
    public function edit(string $id)
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
            ];
            
            $request->validate($validateInput);
            if($request->guests > Settings::first()->pluck('maxGuests')->first()){
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
                    // Booking_Orders
                    $packagePrice = $package->price;
                    $bookingOrder = new BookingOrder;
                    $bookingOrder->bookingId = $booking->id;
                    $bookingOrder->quantity = $request->guests;
                    $bookingOrder->price = $package->price * $request->guests;
                    $bookingOrder->status = "paid";

                    if($bookingOrder->save()){
                        // Bookings Meta/Items
                        $orderItems = [
                            ["type" => 'addon', "id" => 1],
                            ["type" => 'property', "id" => 1]
                        ];
                        
                        foreach($orderItems as $key => $item){
                            $BookingsMeta = new BookingsMeta;
                            $BookingsMeta->bookingId = $booking->id;
                            $BookingsMeta->orderId = $bookingOrder->id;
                            $BookingsMeta->objectType = $item['type'];
                            $BookingsMeta->objectId = $item['id'];
                            if($item['type'] == 'addon'){
                                $addon = Addons::find($item['id']);
                                $BookingsMeta->basePrice = $addon->price;
                                $BookingsMeta->priceType = $addon->priceType;
                                if($addon->priceType == 'unit'){
                                    $BookingsMeta->totalPrice = $addon->price * $request->guests;                                    
                                }else{
                                    $BookingsMeta->totalPrice = $addon->price;
                                }
                            }
                            if($item['type'] == 'property'){
                                $property = Properties::find($item['id']);
                                $BookingsMeta->basePrice = $property->price;
                                $BookingsMeta->priceType = $property->priceType;
                                if($property->priceType == 'unit'){
                                    $BookingsMeta->totalPrice = $property->price * $request->guests;                                    
                                }else{
                                    $BookingsMeta->totalPrice = $property->price;
                                }
                            }
                            $BookingsMeta->save();
                        }
                        return ['success' => true, 'message' => "Order created!", 'status_code' => 200];
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

}
