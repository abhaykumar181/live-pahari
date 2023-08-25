<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings;

class SettingsController extends Controller
{
    protected function index(){
        $settings = Settings::first();
        return view('backend.settings.index',compact('settings'));
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

            $settings = Settings::where('id',1)->first();
            $settings->title = $request->title;
            $settings->slug = getSlug($request->title);
            $settings->thumbnail = $imageName;
            $settings->maxGuests = $request->numberofGuests;
            $settings->CurateifGuests = $request->numberofcuratedGuests;
            $settings->headerscripts = $request->headerscripts;
            $settings->footerscripts = $request->footerscripts;
            if($settings->save()){
                return redirect()->route('admin.settings.index')->with('message','Settings updated successfully.');
            }else{
                return redirect()->route('admin.settings.index')->with('error','Failed to update Settings.');
            }
                        
        }catch(\Illuminate\Database\QueryException $e){
            return redirect()->route('admin.settings.index')->with('error','Failed to update Settings.');
        }
    }

}
