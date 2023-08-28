<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     * 
     * @since 1.0.0
     * 
     * @return html 
     */
    protected function dashboard(){
        return view('backend.dashboard');
    }

    /**
     * Logout the authenticated user.
     * 
     * @since 1.0.0
     * 
     * @return html
     */
    protected function logout(){
        Auth::logout();
        return redirect()->route('admin.login')->with('message','logged out successful.');
    }

}
