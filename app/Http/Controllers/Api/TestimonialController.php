<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonials;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            $limit = $request->limit ? $request->limit : 10; 
            $page = $request->page ? $request->page : 1;
            $offset = (($page - 1) * $limit);
            $orderBy = $request->orderBy ? $request->orderBy : 'id';
            $order = $request->order ? $request->order : 'ASC';
    
            $testimonialQuery = Testimonials::where('name','!=','')->where('status', 1); 
            if($request->search){
                $testimonialQuery->where(strtolower('title'), 'LIKE', '%'.strtolower($request->search).'%'); 
            }
            $totalRows = $testimonialQuery->count();
    
            if($orderBy){
                $testimonialQuery->orderBy($orderBy, $order);
            }
    
            if($limit && $limit > 0){
                $testimonialQuery->skip($offset)->take($limit);
            }
    
            $testimonials = $testimonialQuery->get();
            $data = [
                'success' => true,
                'limit' => $limit,
                'page' => $page,
                'total' => $totalRows,
                'data' => $testimonials
            ];

            if(!$testimonials){
                return response()->json(['error' => true , 'message' => 'Testimonial not found.'] , 404);
            }
    
            return response()->json($data, 200);

        }catch(\Illuminate\Database\QueryException $e){
            return response()->json('Internal Server Error.', 500);
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
