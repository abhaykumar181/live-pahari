<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Locations;

class LocationController extends Controller
{
    /**
     * Locations Listing.
     * 
     * @since 1.0.0
     * 
     * @return html
     */
    protected function index(){
        $locations = Locations::all();
        return view("backend.locations.index",compact('locations'));       
    }

    /**
     * Show the edit page.
     * 
     * @accept loactionId|Integer
     * 
     * @since 1.0.0
     * 
     * @return html
     */
    protected function edit($loactionId=''){ 
       $data['locations'] = Locations::all();  
       $data['location'] = Locations::find($loactionId);
       return view("backend.locations.index", $data);

    }

    /**
     * Create and update locations.
     * 
     * @accept loactionId|Integer
     * 
     * @since 1.0.0
     * 
     * @return html
     */
    protected function store(Request $request){
        try{
            $validateInput = [
                'locationName' => 'required'
            ];
            $request->validate($validateInput);

            $query = Locations::where("name", $request->input('locationName'));
            if($request->input('locationId')){
                $query->where("id", "!=", $request->input('locationId'));
            }

            $location = $query->first();
            if(!is_null($location)){
                return redirect()->back()->with('error', "Same Location already exists.")->withInput();
            }

            if($request->input('locationId')){
                $location = Locations::find($request->input('locationId'));
            }else{
                $location = new Locations;
            }
            $location->name = $request->locationName;
            $location->slug = getSlug($request->locationName);
            
            if($location->save()){
                $successMessage = "Location added successfully.";
                if($request->input('locationId')){
                    $successMessage = "Location updated successfully.";
                }
                return redirect()->route('admin.locations.index')->with('message',$successMessage);
            }
        }catch(\Illuminate\Database\QueryException $e){
            return redirect()->route('admin.locations.index')->with('error','Failed to add location.');
        }
    }
}
