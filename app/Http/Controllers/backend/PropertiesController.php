<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Properties;
use App\Models\Locations;
use App\Models\LocationRelationship;
use \Illuminate\Support\Facades\Auth;

class PropertiesController extends Controller
{
    protected function index(){
        $properties = Properties::all();
        return view('backend.properties.index',compact('properties'));
    }

    protected function create(){
        $data['allLocations'] = Locations::all();
        return view('backend.properties.create',$data);
    }

    protected function edit($propertyId=''){
        $data['property'] = Properties::find($propertyId);
        $data['allLocations'] = Locations::all();
        $data['propertyLocations'] = LocationRelationship::where(['objectType'=>'property', 'objectId'=> $propertyId])->pluck('locationId')->toArray();
        if($data['property']){
            return view('backend.properties.edit',$data);
        }else{
            return redirect()->back()->with('error','Property doesn\'t exist');
        }
    }

    protected function store(Request $request){
        
       try{
        $validateInput = [
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'priceType' => 'required',
            'addon_status' => 'required',
            'ownerName' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'confirmation' => 'required',
            'excerpt' => 'required',
        ];

        $request->validate($validateInput);

        if($request->post('id') === false){
            $validateInput['thumbnail'] = "required";
        }

        $imageName = $request->thumbnailName ? $request->thumbnailName : null;
        if($request->hasFile('thumbnail')){
            $imageName = time() . '.' . $request->thumbnail->extension();
            $request->thumbnail->move(public_path('storage/images'), $imageName);
        }

        if($request->post('id')){
            $property = Properties::find($request->post('id'));
        }else{
            $property = new Properties;
            $property->userId = Auth::user()->id;
        }

        $property->title = $request->title;
        $property->slug = getSlug($request->title);
        $property->description = $request->description;
        $property->excerpt = $request->excerpt;
        $property->thumbnail = $imageName;
        $property->priceType = $request->priceType;
        $property->price = $request->price;
        $property->status = $request->addon_status;
        $property->ownerName = $request->ownerName;
        $property->email = $request->email;
        $property->phone = $request->phone;
        $property->confirmationRequired = $request->confirmation;

        if($property->save()){

            $updateLocations = false;
            if($request->post('id')){
                $existingAddonLocations = LocationRelationship::where([
                    'objectType' => 'property',
                    'objectId' => $request->post('id')
                ])->pluck('locationId')->toArray();

                if(!empty($existingAddonLocations)){
                    foreach($existingAddonLocations as $locationId){
                        if(!in_array($existingAddonLocations,$request->locations)){
                            $updateLocations = true;                            
                        }
                    }

                    if(count(array_diff($request->locations,$existingAddonLocations)) > 0){
                        $updateLocations = true;
                    }
                }

            }else{
                $updateLocations = true;
            }


            if($updateLocations === true){
                if($request->post('id')){
                    LocationRelationship::where(
                        ['objectId' => $request->post('id'),'objectType' => 'property']
                    )->delete();
                }

                $data = [];
                if(!empty($request->locations)){
                    foreach($request->locations as $location){
                        $data[] = [
                            'objectId' => $property->id,
                            'objectType' => 'property',
                            'locationId' => $location
                        ];
                    }
                }

                if(!empty($data)){
                    LocationRelationship::insert($data);
                }
            }

            if($request->post('id')){
                return redirect()->route('admin.properties.index')->with('message','Property updated successfully.');
            }else{
                return redirect()->route('admin.properties.index')->with('message','Property added successfully.');
            }
        }

        foreach($request->locations as $location){
            $data[] = [
                'objectType' => "property",
                'objectId' => $property->id,
                'locationId' => $location,
            ]; 
        }

        if(!empty($data)){
            LocationRelationship::insert($data);
        }
       }catch(\Illumiate\Database\QueryException $e){
            if($request->post('id')){
                return redirect()->route('admin.properties.index')->with('error','Failed to update Property.');
            }else{
                return redirect()->route('admin.properties.index')->with('error','Failed to add Property.');                
            }
       }

    }

    /**
     * Delete Property
     * 
     * @since 1.0.0
     * 
     * @accept $propertyId | Integer
     * return redirection
     */
    protected function delete($propertyId){
        try{
            $property = Properties::find($propertyId);
            if(!$property){
                return redirect()->back()->with('error','Property doesn\'t exist');
            }else{
                if($property->delete()){
                    return redirect()->back()->with('message','Property deleted successfully.');
                }else{
                    return redirect()->back()->with('error','Failed to delete Property.');
                }
            }

        }catch(\Illuminate\Database\QueryException $e){
            return redirect()->route('admin.properties.index')->with('error','Failed to delete Property.');
        }
    }

}
