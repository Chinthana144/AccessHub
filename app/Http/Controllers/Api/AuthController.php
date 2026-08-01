<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

        return response()->json([
            'user' => $user,
            'token' => $token,
            'message' => 'Login Successful!'
        ]);
    }//login

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully.'
        ]);
    }//logout
    
}//class
