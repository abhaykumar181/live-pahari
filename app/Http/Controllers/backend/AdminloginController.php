<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminloginController extends Controller
{
    /**
     * Show the login page.
     * 
     * @since 1.0.0
     * 
     * @return html
     */
    protected function login(){
        if(Auth::check() === true){
            return redirect(route('admin.dashboard'));
        }
        return view('backend.auth.login');
    }

    /**
     * Authenticate User
     * 
     * @accept Email|Password
     * 
     * @since 1.0.0
     * 
     * @return redirection
     */
    protected function checklogin(Request $request){
        try{
            $validateInput = [
                'email' => 'required|Email',
                'password' => 'required'
            ];
            $request->validate($validateInput);
    
            if(Auth::attempt(['email' => $request->email , 'password' => $request->password])){
                return redirect()->intended(route('admin.dashboard'))->with('message','login Successful.');
            }
            return redirect(route('admin.login'))->with('error','login failed.');
        }
        catch(\Illuminate\Database\QueryException $e){
            return redirect(route('admin.login'))->with('error','login failed.');
        }
        
    }
}
