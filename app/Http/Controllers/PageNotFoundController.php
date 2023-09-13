<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageNotFoundController extends Controller
{
    protected function index(){
        abort(404);
    }
}
