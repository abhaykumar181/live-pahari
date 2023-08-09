<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonials;

class TestimonialController extends Controller
{
    protected function index(){
        $testimonials = Testimonials::all();
        return view('backend.testimonials.index', compact('testimonials'));
    }

    protected function create(){
        return view('backend.testimonials.create');
    }

    protected function edit($testimonialId){
        $testimonial = Testimonials::find($testimonialId);
        return view('backend.testimonials.edit',compact('testimonial'));
    }

    protected function store(Request $request){
        try{
            $validateInput = [
                'name' => 'required',
                'title' => 'required',
                'testimonial' => 'required',
                'testimonial_status' => 'required'
            ];
            $request->validate($validateInput);
    
            $imageName = null;
            if($request->hasFile('thumbnail')){
                $imageName = time() . '.' . $request->thumbnail->extension();
                $request->thumbnail->move(public_path('/testimonials/images'), $imageName);
            }

            $testmonial = new Testimonials;
            $testmonial->name = $request->name;
            $testmonial->title = $request->title;
            $testmonial->testimonial = $request->testimonial;
            $testmonial->thumbnail = $imageName;
            $testmonial->status = $request->testimonial_status;
            
            if($testmonial->save()){
                return redirect()->route('admin.testimonials.index')->with('message','Testimonial added successfully.');
            }
        }
        catch(\Illuminate\Database\QueryException $e){
            return redirect()->route('admin.testimonials.index')->with('error',"Failed to add Testimonial .'$e'.");
        }

    }

}
