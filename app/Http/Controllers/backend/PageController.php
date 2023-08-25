<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pages;
use \Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    /**
     * Page Listing
     * 
     * @since 1.0.0
     * 
     * return html
     */
    protected function index(){
        $allpages = Pages::all();
        return view('backend.pages.index',compact('allpages'));
    }


    /**
     * Create Page
     * 
     * @since 1.0.0
     * 
     * return redirection
     */

     protected function create(){
        return view('backend.pages.create');
     }

     /**
     * Edit Page
     * 
     * @since 1.0.0
     * 
     * return redirection
     */

     protected function edit($pageId=''){
        $page = Pages::find($pageId);
        if(!$page){
            return redirect()->back()->with('error','Page doesn\'t exist.');
        }else{
            return view('backend.pages.edit',compact('page'));
        }
     }


    /**
     * Store|Edit Page
     * 
     * @accept String
     * 
     * @since 1.0.0
     * 
     * return redirection 
     */

     protected function store(Request $request){
        try{
            $validateInput = [
                'title' => 'required',
                'description' => 'required',
                'excerpt'=> 'required',
                'pageStatus' => 'required'
            ];

            $request->validate($validateInput);

            if($request->post('id')){
                $page = Pages::find($request->post('id'));
            }else{
                $page = new Pages;
                $page->userId = Auth::user()->id;
            }
            $page->title = $request->title;
            $page->slug = getSlug($request->title);
            $page->description = $request->description;
            $page->excerpt = $request->excerpt;
            $page->status = $request->pageStatus;

            if($page->save()){
                if($request->post('id')){
                    return redirect()->route('admin.pages.edit',['pageId' => $request->post('id')])->with('message','Page updated successfully.');
                }else{
                    return redirect()->route('admin.pages.index')->with('message','Page created successfully.');
                }
            }

        }catch(\Illuminate\Database\QueryException $e){
            if($request->post('id')){
                return redirect()->back()->with('error','Failed to update Page.');
            }else{
                return redirect()->back()->with('error','Failed to create Page.');
            }
        }

     }


    /**
     * Delete Page
     * 
     * @accept Integer
     * 
     * @since 1.0.0
     * 
     * return redirection 
     */

     protected function delete($pageId=''){
        $page = Pages::find($pageId);
        if(!$page){
            return redirect()->back()->with('error','Page doesn\'t exist.');
        }else{
            if($page->delete()){
                return redirect()->route('admin.pages.index')->with('message','Page deleted successfully.');
            }else{
                return redirect()->back()->with('error','Failed to delete Page.');
            }
        }
     }


}
