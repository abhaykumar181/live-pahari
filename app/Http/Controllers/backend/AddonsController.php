<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Addons;
use App\Models\Locations;
use App\Models\LocationRelationship;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddonsController extends Controller
{
    protected function index(){
        $addons = Addons::all();
        return view('backend.addons.index',compact('addons'));
    }

    protected function create(){
        $data['allLocations'] = Locations::all();
        return view('backend.addons.create',$data);
    }

    protected function edit($addonId){
        $data['allLocations'] = Locations::all();
        $data['addons'] = Addons::find($addonId);
        return view('backend.addons.edit', $data);
    }

    protected function store(Request $request){
        try{
            dd($request->all());
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
                $request->thumbnail->move(public_path('storage/addons/images'), $imageName);
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
                if($request->post('id')){
                    return redirect()->route('admin.addons.index')->with('message','Addon updated successfully.');
                }else{
                    foreach($request->locations as $location){
                        $data[] = [
                            'objectType' => "addon",
                            'objectId' => $addon->id,
                            'locationId' => $location,
                        ]; 
                    }

                    DB::table('pahhos_location_relationship')->insert($data);
                    return redirect()->route('admin.addons.index')->with('message','Addon added successfully.');
                }
            }
        }
        catch(\Illuminate\Database\QueryException $e){
            if($request->post('id')){
                return redirect()->route('admin.addons.index')->with('error','Failed to update Addon.');
            }else{
                return redirect()->route('admin.addons.index')->with('error','Failed to add Addon.');
            }
        }

    }


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
