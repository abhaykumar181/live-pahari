<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected function dashboard(){
        return view('backend.dashboard');
    }

    protected function logout(){
        Auth::logout();
        return redirect()->route('admin.login')->with('message','logged out successful.');
    }

    public function settings(){
        $data["welcome"] = "Welcome to this page";
        $data["content"] = "Please add your content";
        return view('backend.settings', $data);
    }
}
