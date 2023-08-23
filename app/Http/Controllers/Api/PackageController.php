<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Packages;
use App\Models\LocationRelationship;
use App\Models\Locations;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            $limit = $request->limit ? $request->limit : 20;
            $page = $request->page ? $request->page : 1;
            $offset = (($page - 1) * $limit);
            $orderBy = $request->orderBy ? $request->orderBy : 'id';
            $order = $request->order ? $request->order : 'ASC'; 
        
            $packageQuery = Packages::where('userId', '!=' , '');
            if($request->days){
                $packageQuery->where('days', $request->days);
            }

            if($request->search){    
                $packageQuery->where(strtolower('title'),'LIKE','%'.strtolower($request->search).'%');
            }
            
            $totalRows = $packageQuery->count();

            if($orderBy){
                $packageQuery->orderBy($orderBy, $order);
            }
            
            if($limit && $limit> 0){
                $packageQuery->skip($offset)->take($limit);
            }
            
            $packages = $packageQuery->get()->toArray();
            
            if(!empty($packages)){
                $packages = array_map("render_thumbnail_url", $packages);
            }

            $data = [
                'success'   =>  true,
                'limit' => $limit,
                'page'  =>  $page,
                'total'  =>  $totalRows,
                'data'  =>  $packages
            ];

            return response()->json($data, 200);
            
        }catch(\Illuminate\Database\QueryException $e){
            return response()->json('Internal Server Error\$e.', 500);
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
       try{
            $packages = new Packages;
            $packages->userId = '2';
            $packages->title = $request->title;
            $packages->slug = getSlug($request->title);
            $packages->description = $request->description;
            $packages->howToReach = $request->howToReach;
            $packages->extraDetails = $request->extraDetails;
            $packages->thumbnail = $request->thumbnail;
            $packages->price = $request->price;
            $packages->days = $request->days;
            if($packages->save()){
                return response()->json(['success'=>'Package created successfully.'], 200);
            }else{
                return response()->json(['error'=>'Failed to create.'], 404);
            }
       }catch(\Illuminate\Database\QueryException $e){
        return response()->json(['error'=>'Failed to create.'], 404);
       }


    }

    /**
     * Display the specified resource.
     */ 
    public function show(string $slug)
    {
        try{
            $package = Packages::where('slug','=',$slug)->with('gallery','itineraries')->get();
            $data = [
                'success' => true,
                'data' => $package
            ];

            if(count($package) === 0){
                return response(['error' => 'Package not Found.'], 404);
            }else{
                return response()->json($data, 200);
            }
       }catch(\Illuminate\Database\QueryException $e){
            return response()->json(['error'=>'Internal server error.'], 500);
       }
        
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
