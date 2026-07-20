<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $roles = Roles::all();
        $users = User::paginate(10);

        return view('users.users_view', compact('roles', 'users'));
    }//index

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
        ]);

        User::create([
            'name' => $validate['name'],
            'email' => $validate['email'],
            'password' => $validate['password'],
            'role_id' => $request->input('cmb_role'),
        ]);

        return redirect()->route('users.index');
    }//store    
}//class
