<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard(){
        return view('backend.auth.dashboard');
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
