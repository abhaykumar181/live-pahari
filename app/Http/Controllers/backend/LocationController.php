<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Locations;

class LocationController extends Controller
{
    protected function index(){
        $locations = Locations::all();
        return view("backend.locations.index",compact('locations'));
    }

    protected function edit($loactionId=''){
        // return view 
    }

    protected function store(Request $request){
        try{
            $validateInput = [
                'location' => 'required'
            ];
            $request->validate($validateInput);

            $location = new Locations;
            $location->name = $request->location;
            $location->slug = getSlug($request->location);
            
            if($location->save()){
                return redirect()->route('admin.locations.index')->with('message','Location added successfully.');
            }

        }catch(\Illuminate\Database\QueryException $e){
            return redirect()->route('admin.locations.index')->with('error','Failed to add location.');
        }
    }

}
