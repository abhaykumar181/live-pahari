<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        return view('backend.pages.index');
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
     * Store|Edit Page
     * 
     * @accept String
     * 
     * @since 1.0.0
     * 
     * return redirection 
     */

     protected function store(Request $request){
        // dd($request->all());
        $validateInput = [
            'title' => 'required',
            'description' => 'required',
            'excerpt'=> 'required',
            'status' => 'required'
        ];

        $request->validate($validateInput);


     }


}
