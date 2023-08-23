<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Addons;

class AddonsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            $limit = $request->limit ? $request->limit : '10'; 
            $page = $request->page ? $request->page : '1';
            $offset = (($page - 1) * $limit);
            $orderBy = $request->orderBy ? $request->orderBy : 'id';
            $order = $request->order ? $request->order : 'ASC';         
            
            $addonsQuery = Addons::where('userId', '!=', '')->where('status','1');

            if($request->search){
                $addonsQuery->where(strtolower('title'), 'LIKE', '%'.strtolower($request->search).'%');
            }

            $totalRows = $addonsQuery->count();

            if($order){
                $addonsQuery->orderBy($orderBy, $order);
            }

            if($limit && $limit > 0){
                $addonsQuery->skip($offset)->take($limit);
            }

            $addons = $addonsQuery->get()->toArray();

            if(!empty($addons)){
                $addons = array_map("render_thumbnail_url", $addons);
            }

            $data = [
                'success' => true,
                'limit' => $limit,
                'page' => $page,
                'total' => $totalRows,
                'data' => $addons
            ];

            return response()->json($data, 200);
            
        }catch(\Illuminate\Database\QueryException $e){
            return response()->json('internal Server Error', 500);
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
