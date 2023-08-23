<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Addons;
use App\Models\Locations;
use App\Models\LocationRelationship;
use Illuminate\Support\Facades\Auth;

class AddonsController extends Controller
{
    /**
     * add-on listing
     * 
     * @since 1.0.0
     * 
     * @return html
     */
    protected function index(){
        $addons = Addons::all();
        return view('backend.addons.index',compact('addons'));
    }

    /**
     * create add-on
     * 
     * @since 1.0.0
     * 
     * @return html
     */
    protected function create(){
        $data['allLocations'] = Locations::all();
        return view('backend.addons.create',$data);
    }

    /**
     * edit add-on
     * 
     * @since 1.0.0
     * 
     * @accept addonId | Integer
     * @return html | redirection
     */
    protected function edit($addonId=''){
        $data['allLocations'] = Locations::all();
        $data['addons'] = Addons::find($addonId);
        $data['addOnLocations'] = LocationRelationship::where('objectType','=','addon')->where('objectId','=',$addonId)->pluck('locationId')->toArray();
        if(($data['addons'])){
            return view('backend.addons.edit', $data);
        }else{
            return redirect()->route('admin.addons.index')->with('error', "Add-on doesn't exists.")->withInput();
        }
    }


    /**
     * store add-on
     * 
     * @since 1.0.0
     * 
     * @accept request
     * @return redirection
     */
    protected function store(Request $request){
        try{
            $validateInput = [
                'title' => 'required',
                'description' => 'required',
                'price' => 'required',
                'priceType' => 'required',
                'addon_status' => 'required',
            ];

            if($request->post('id') === false){
                $validateInput['thumbnail'] = "required";
            }

            $request->validate($validateInput);
    
            $imageName = $request->thumbnailName ? $request->thumbnailName : null;
            if($request->hasFile('thumbnail')){
                $imageName = time() . '.' . $request->thumbnail->extension();
                $request->thumbnail->move(public_path('storage/images'), $imageName);
            }
            
            if($request->post('id')){
                $addon = Addons::find($request->post('id'));
            }else{  
                $addon = new Addons;
                $addon->userId = Auth::user()->id;
            }
            
            $addon->title = $request->title;
            $addon->slug = getSlug($request->title);
            $addon->description = $request->description;
            $addon->thumbnail = $imageName;
            $addon->priceType = $request->priceType;
            $addon->price = $request->price;
            $addon->status = $request->addon_status;
            
            if($addon->save()){

                $updateLocations = false;
                if($request->post('id')){
                    $existingAddonLocations = LocationRelationship::where([
                        'objectId' => $request->post('id'),
                        'objectType' => 'addon',
                    ])->pluck('locationId')->toArray();

                    if(!empty($existingAddonLocations)){
                        foreach($existingAddonLocations as $locationId){
                            if(!in_array($locationId, $request->locations)){
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


                if($updateLocations == true){

                    if($request->post('id')){
                        LocationRelationship::where([
                            'objectId' => $request->post('id'),
                            'objectType' => 'addon',
                        ])->delete();
                    }

                    $data = [];

                    if(!empty($request->locations)){
                        foreach($request->locations as $locationId){
                            $data[] = [
                                'objectType' => "addon",
                                'objectId' => $addon->id,
                                'locationId' => $locationId,
                            ]; 
                        }
                    }
            
                    if(!empty($data)){
                        LocationRelationship::insert($data);
                    }
                }

                if($request->post('id')){
                    return redirect()->route('admin.addons.index')->with('message','Addon updated successfully.');
                }else{
                    return redirect()->route('admin.addons.index')->with('message','Addon added successfully.');
                }

            }
        }
        catch(\Illuminate\Database\QueryException $e){
            if($request->post('id')){
                return redirect()->route('admin.addons.index')->with('error','Failed to update Addon.');
            }else{
                return redirect()->route('admin.addons.index')->with('error',"Failed to add Addon.");
            }
        }

    }


    /**
     * Delete add-on
     * 
     * @since 1.0.0
     * 
     * @accept $addonId |  Integer
     * @return redirection
     */
    protected function delete($addonId){
        try{            
            $addon = Addons::find($addonId);
            if(!$addon){
                return redirect()->back()->with('error','Failed to delete Addon.');
            }else{
                if($addon->delete()){
                    return redirect()->back()->with('message','Addon deleted successfully.');
                }else{
                    return redirect()->back()->with('error','Failed to delete Addon.');
                }
            }
        }catch(\Illuminate\Database\QueryException $e){
            return redirect()->route('admin.addons.index')->with('error','Failed to delete addon.');
        }
    }
}
