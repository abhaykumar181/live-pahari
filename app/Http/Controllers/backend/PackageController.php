<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Locations;
use App\Models\LocationRelationship;
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
        return view('backend.packages.index');
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
}
