<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bookings;
use App\Models\Packages;

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
            
            if($request->packageId){
                $packageDays = Packages::where(['id'=>$request->packageId])->pluck('days')->first();
                $packageId = ($request->packageId < 10 && $request->packageId > 0 )? '0'.$request->packageId : $request->packageId;
            }
            $trimcheckinDate = str_replace('-','',$request->checkinDate);   
            $bookingCode = "PHID".$packageId.$trimcheckinDate;
            $checkOutdate = date('Y-m-d', strtotime($request->checkinDate. ' + '.$packageDays.' days'));

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

            $data = [
                'success' => true,
                'message' => "Your Package has been Booked successfully."
            ];

            if($booking->save()){
                return response()->json($data, 200);
            }else{
                return response()->json(['error'=>true, 'message'=>'Order Booking Failed.'], 500);
            }


        }catch(\Illuminate\Database\QueryException $e){
            return response()->json('Internal Server Error.', 500);
        }
        
    }

}
