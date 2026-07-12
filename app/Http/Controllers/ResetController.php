<?php

namespace App\Http\Controllers;

use App\Models\CampAccess;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ResetController extends Controller
{
    public function index()
    {
        return view('reset.reset_login');
    }//index

    public function resetLogin(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        //check email
        $user = User::where("email", $username)->first();
        // dd($user);
        if($user)
        {
            //check password
            if(Hash::check($password, $user->password))
            {
                //password match
                Session::put("reset_user", $user);
                return redirect()->route('reset.page');
            }
            else{
                return redirect()->route('reset.index')->with('error', 'Invalid password, please try again!');
            }
        }//has user
        else{
            return redirect()->route('reset.index')->with('error', 'No user found, please try again!');
        }//no user
    }//reset login

    public function resetPage(Request $request)
    {
        $user = Session::get('reset_user');
        $user_camps = CampAccess::where("user_id", $user->id)->get();

        return view('reset.reset', compact('user', 'user_camps'));
    }//reset page
}//class
