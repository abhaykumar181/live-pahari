<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonials;

class TestimonialController extends Controller
{
    /**
     * Shows Testimonial Listing.
     * 
     * @since 1.0.0
     * 
     * @return html
     */
    protected function index(){
        $testimonials = Testimonials::all();
        return view('backend.testimonials.index', compact('testimonials'));
    }

    /**
     * Display testimonial page.
     * 
     * @since 1.0.0
     * 
     * @return html
     */
    protected function create(){
        return view('backend.testimonials.create');
    }

    /**
     * Display edit testimonial page.
     * 
     * @since 1.0.0
     * @accept $testimonialId|Integer
     * 
     * @return html|redirection 
     */
    protected function edit($testimonialId){
        $testimonial = Testimonials::find($testimonialId);
        if($testimonial){
            return view('backend.testimonials.edit',compact('testimonial'));
        }else{
            return redirect()->route('admin.testimonials.index')->with('error', "This testimonial doesn't exists.")->withInput();
        }
    }

    /**
     * Create and store 
     * 
     * @since 1.0.0
     * 
     * @return redirection
     */
    protected function store(Request $request){
        try{
            $validateInput = [
                'name' => 'required',
                'title' => 'required',
                'testimonial' => 'required',
                'testimonial_status' => 'required',
                'excerpt' => 'required'
            ];
            $request->validate($validateInput);
    
            $imageName = $request->thumbnailName? $request->thumbnailName : null;
            if($request->hasFile('thumbnail')){
                $imageName = getSlug($request->title) . '.' . $request->thumbnail->extension();
                $request->thumbnail->move(public_path('storage/images'), $imageName);
            }

            if($request->post('id')){
                $testmonial = Testimonials::find($request->post('id'));
            }else{
                $testmonial = new Testimonials;
            }

            $testmonial->name = $request->name;
            $testmonial->title = $request->title;
            $testmonial->testimonial = $request->testimonial;
            $testmonial->excerpt = $request->excerpt;
            $testmonial->thumbnail = $imageName;
            $testmonial->status = $request->testimonial_status;
            
            if($testmonial->save()){
                if($request->post('id')){
                    return redirect()->route('admin.testimonials.index')->with('message','Testimonial updated successfully.');
                }else{
                    return redirect()->route('admin.testimonials.index')->with('message','Testimonial added successfully.');
                }
            }
        }
        catch(\Illuminate\Database\QueryException $e){
            if($request->post('id')){
                return redirect()->route('admin.testimonials.index')->with('error','Failed to update Testimonial.');
            }else{
                return redirect()->route('admin.testimonials.index')->with('error','Failed to add Testimonial.');
            }
        }

    }

    /**
     * Delete Testimonial
     * 
     * @accept $testimonialId|integer
     * @since 1.0.0
     * 
     * @return redirection
     */
    protected function delete($testimonialId){
        try{
            $testimonial = Testimonials::find($testimonialId);
            if(!$testimonial){
                return redirect()->back()->with('error','Failed to delete Testimonial.');
            }else{
                if($testimonial->delete()){
                    return redirect()->back()->with('message','Testimonial deleted successfully.');
                }else{
                    return redirect()->back()->with('error','Failed to delete Testimonial.');
                }
            }
        }catch(\Illuminate\Database\QueryException $e){
            return redirect()->route('admin.testimonials.index')->with('error','Failed to delete Testimonial.');
        }
    }




}
