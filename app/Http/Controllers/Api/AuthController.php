<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CampAccess;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if(!$user || !Auth::attempt($credentials))
        {
            return response()->json([
                'message' => 'Invalid credentials.'
            ], 401);
        }//failed

        //delete previous token
        $user->tokens()->delete();

        $token = $user->createToken('AccessHub Mobile')->plainTextToken;

        //user camps
        $user_camps = CampAccess::where('user_id', $user->id)->get();
        $camps = [];
        foreach ($user_camps as $camp) {
            $camps[] = [
                'camp_id' => $camp->camp->id,
                'camp_name' => $camp->camp->name,
            ];
        }//foreach

        return response()->json([
            'user' => $user,
            'camps' => $camps,
            'token' => $token,
            'message' => 'Login Successful!'
        ]);
    }//login

    public function testAPI(){
        return response()->json([
            'success' => true,
            'message' => "API is working"
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully.'
        ]);
    }//logout
    
}//class
