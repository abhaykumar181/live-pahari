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
       $data['locations'] = Locations::all();  
       $data['location'] = Locations::find($loactionId);
       return view("backend.locations.index", $data);

    }

    protected function store(Request $request){
        try{
            $validateInput = [
                'locationName' => 'required'
            ];
            $request->validate($validateInput);

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
