<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings;

class SettingsController extends Controller
{
    /**
     * 
     */
    protected function settings(){
        $settings = Settings::first();
        if(!$settings){
            return redirect()->back()->with('error','Failed to open settings.');
        }
        return view('backend.settings',compact('settings'));
       
    }
    
    protected function store(Request $request){
        try{
            $validateInput = [
                'title' => 'required',
                'numberofGuests' => 'required',
                'numberofcuratedGuests' => 'required',
            ];

            $request->validate($validateInput);

            $imageName = $request->thumbnailName ? $request->thumbnailName : null;
            if($request->hasFile('logo')){
                $imageName = time() . '.' . $request->logo->extension();
                $request->logo->move(public_path('storage/images'), $imageName);
            }

            $settings = Settings::first();
            $settings->title = $request->title;
            $settings->slug = getSlug($request->title);
            $settings->thumbnail = $imageName;
            $settings->maxGuests = $request->numberofGuests;
            $settings->CurateifGuests = $request->numberofcuratedGuests;
            $settings->headerscripts = $request->headerscripts;
            $settings->footerscripts = $request->footerscripts;
            
            if($settings->save()){
                return redirect()->route('admin.settings.settings')->with('message','Settings updated successfully.');
            }else{
                return redirect()->back()->with('error','Failed to update Settings.');
            }

        }catch(\Illuminate\Database\QueryException $e){
            return redirect()->back()->with('error','Failed to update Settings.');
        }
    }

}
