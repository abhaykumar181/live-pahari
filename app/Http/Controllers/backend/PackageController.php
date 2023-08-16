<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Locations;
use App\Models\LocationRelationship;
use App\Models\Packages;
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
     *  get Accordion
     * 
     *  @since 1.0.0
     * 
     *  return html 
     */
    protected function getAccordion(Request $request){
        
        $content = '';
        for($i=1; $i<=$request->days; $i++ ){
            $content = '
                <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-heading'.$i.'">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse'.$i.'" aria-expanded="true" aria-controls="panelsStayOpen-collapse'.$i.'">
                        Day '.$i.'
                    </button>
                    </h2>
                    <div id="panelsStayOpen-collapse'.$i.'" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-heading'.$i.'">
                        <div class="accordion-body">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Title</span>
                                <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group">
                                <span class="input-group-text">With textarea</span>
                                <textarea class="form-control" aria-label="With textarea"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            ';
        }

        $dayCount = 1;
        if($request->days > $dayCount ){
            $dayCount = $request->days + 1;
        }
        elseif ($request->days == $dayCount ) {
            $dayCount = $request->days;
        }else{
            $dayCount = $request->days - 1;
        }

        return response()->json([$content,$dayCount]);
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
            $package->howToReach = $request->howtoReach;
            $package->extraDetails = $request->extraDetails;
            $package->thumbnail = $imageName;
            $package->price = $request->price;
            $package->days = "5";
    
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
                    return redirect()->route('admin.packages.index')->with('message','Package updated successfully.');
                }else{
                    return redirect()->route('admin.packages.index')->with('message','Package added successfully.');
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
            $package = Properties::find($packageId);
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
}
