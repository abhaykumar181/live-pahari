<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Locations;
use App\Models\LocationRelationship;
use App\Models\Packages;
use App\Models\Itineraries;
use carbon\carbon;
use \Illuminate\Support\Facades\Auth;

class PackageController extends Controller
{
    /**
     *  Packages Listing
     * 
     *  @since 1.0.0
     * 
     *  return html 
     */

    protected function index(){
        $packages = Packages::all();
        return view('backend.packages.index',compact('packages'));
    }

    /**
     *  Create Package
     * 
     *  @since 1.0.0
     * 
     *  return html 
     */
    protected function create(){
        $data['allLocations'] = Locations::all();
        return view('backend.packages.create',$data);
    }

    /**
     *  Create Package
     * 
     *  @since 1.0.0
     * 
     *  return html 
     */
    protected function edit($packageId){
        $data['package'] = Packages::find($packageId);
        $data['allLocations'] = Locations::all();
        $data['propertyLocations'] = LocationRelationship::where(['objectType'=>'package', 'objectId'=> $packageId])->pluck('locationId')->toArray();
        
        $data['packageItineraries'] = Itineraries::where(['packageId' => $packageId])->get();
        // dd($data['packageItineraries']);

        if($data['package']){
            return view('backend.packages.edit',$data);
        }else{
            return redirect()->back()->with('error','Package doesn\'t exist');
        }
    }

    /**
     *  get Itineraries
     * 
     *  @since 1.0.0
     * 
     *  return html 
     */
    protected function gerItineraries(Request $request){
    
        $data['itenariesDays'] = $request->addNewdays;
        $data['currentItems'] =  $request->currentItems +1;
        
        $data['content']= view('backend.partials.itinerariesItems',$data)->render();

        return response()->json($data);
    }
                

    /**
     *  Store and create Package
     * 
     *  @since 1.0.0
     * 
     *  return redirection 
     */
    protected function store(Request $request){
        try{
            $validateInput = [
                'title' => 'required',
                'description' => 'required',
                'price' => 'required',
                'howtoReach' => 'required',
                'extraDetails' => 'required',
                'numberofDays' => 'required',
            ];
    
            $request->validate($validateInput);
    
            if($request->post('id') === false){
                $validateInput['thumbnail'] = "required";
            }
    
            $imageName = $request->thumbnailName ? $request->thumbnailName : null;
            if($request->hasFile('thumbnail')){
                $imageName = time() . '.' . $request->thumbnail->extension();
                $request->thumbnail->move(public_path('storage/packages/images'), $imageName);
            }
    
            if($request->post('id')){
                $package = Packages::find($request->post('id'));
            }else{
                $package = new Packages;
                $package->userId = Auth::user()->id;
            }
    
            $package->title = $request->title;
            $package->slug = getSlug($request->title);
            $package->description = $request->description;
            $package->thumbnail = $imageName;
            $package->price = $request->price;
            $package->howToReach = $request->howtoReach;
            $package->extraDetails = $request->extraDetails;
            $package->days = $request->numberofDays;
    
            if($package->save()){
                $updateLocations = false;
                if($request->post('id')){
                    $existingAddonLocations = LocationRelationship::where([
                        'objectType' => 'package',
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
                            ['objectId' => $request->post('id'),'objectType' => 'package']
                        )->delete();
                    }
    
                    $data = [];
                    if(!empty($request->locations)){
                        foreach($request->locations as $location){
                            $data[] = [
                                'objectId' => $package->id,
                                'objectType' => 'package',
                                'locationId' => $location
                            ];
                        }
                    }
    
                    if(!empty($data)){
                        LocationRelationship::insert($data);
                    }
                }
    
                if($request->post('id')){
                    return redirect()->route('admin.packages.edit', ['packageId' => $package->id] )->with('message','Package updated successfully.');
                }else{
                    return redirect()->route('admin.packages.edit', ['packageId' => $package->id,'section'=>'#packageDetails'])->with('message','Your Package has been created successfully. Now you can add Itineraries.');
                }
            }
    
            foreach($request->locations as $location){
                $data[] = [
                    'objectType' => "package",
                    'objectId' => $package->id,
                    'locationId' => $location,
                ]; 
            }
    
            if(!empty($data)){
                LocationRelationship::insert($data);
            }
           }catch(\Illumiate\Database\QueryException $e){
                if($request->post('id')){
                    return redirect()->route('admin.packages.index')->with('error','Failed to update Package.');
                }else{
                    return redirect()->route('admin.packages.index')->with('error','Failed to add Package.');                
                }
           }
    }


    /**
     * Delete Package
     * 
     * @since 1.0.0
     * 
     * @accept $packageId | Integer
     * return redirection
     */
    protected function delete($packageId){
        try{
            $package = Packages::find($packageId);
            if(!$package){
                return redirect()->back()->with('error','Package doesn\'t exist');
            }else{
                if($package->delete()){
                    return redirect()->back()->with('message','Package deleted successfully.');
                }else{
                    return redirect()->back()->with('error','Failed to delete Package.');
                }
            }

        }catch(\Illuminate\Database\QueryException $e){
            return redirect()->route('admin.properties.index')->with('error','Failed to delete Package.');
        }
    }

    /** 
     * store itineraries
     * 
     * @since 1.0.0
     *
     * return redirection 
     */
    protected function storeItineraries(Request $request){
        try{
            // dd($request->numberofDays .'|'.count($request->itineraryDay));

            $validateInput = [
                'itinaryTitle[]' => 'required',
                'itineraryDescription[]' => 'required',
            ];
            $validationMessages = [
                'itinaryTitle[].required' => 'Please fill all Itinerary Titles.',
                'itineraryDescription[].required' => 'Please fill all Itinerary Description.'
            ];
            $request->validate($validateInput,$validationMessages);

            if($request->numberofDays != count($request->itineraryDay)){
                return redirect()->back()->with('error','Itineraries can\'t be updated');
            }

            $existingItineraries = Itineraries::where(['packageId'=>$request->packageId])->pluck('day')->toArray();
            if(!empty($existingItineraries)){
                foreach($existingItineraries as $key => $itinerary){
                    if(!in_array($itinerary,$request->itineraryDay)){
                        Itineraries::where(
                            ['packageId' => $request->packageId,'day' => $itinerary]
                        )->delete();
                    }
                }
            }

            foreach($request->itinaryTitle as $index=>$title){
                $packageItinerary = Itineraries::where([
                    'packageId' => $request->packageId, 
                    'day' => $request->itineraryDay[$index], 
                ])->first();
                
                if(is_null($packageItinerary)){
                    $packageItinerary = new Itineraries;
                    $packageItinerary->packageId = $request->packageId;
                    $packageItinerary->day = $request->itineraryDay[$index];
                }

                $packageItinerary->title = $title;
                $packageItinerary->description = $request->itineraryDescription[$index];
                $packageItinerary->save();
            }

            

            $package = Packages::find($request->packageId);
            $package->days = $request->numberofDays;
            if($package->save()){
                return redirect()->route('admin.packages.edit', ['packageId' => $request->packageId])->with('message','Itineraries updated successfully.');
            }else{
                return redirect()->back()->with('error','Failed! Please try again.');
            }

        }catch(\Illuminate\DatabaseQueryException $e){
            return redirect()->back()->with('error','Failed to store the Itineraries.');
        }
    }
}
