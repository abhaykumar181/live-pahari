<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bookings;

class BookingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->limit ? $request->limit : '20';
        $page = $request->page ? $request->page : '1';
        $offset = (($page - 1) * $limit);
        $order = $request->order ? $request->order : 'ASC';
        $orderBy = $request->orderBy ? $request->order : 'id';

        $bookingsQuery = Bookings::where('bookingCode', '!=', '')->where('status','active');

        if($request->guests){
            $bookingsQuery->where('guests', 'LIKE', '%'.$request->guests.'%');
        }



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
}
