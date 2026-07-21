<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $roles = Roles::where('id', '>', 1)->get();
        $users = User::where('id', '>', 1)->paginate(10);

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

    //update role, name and email
    public function update(Request $request)
    {
        $user_id = $request->input('hide_user_id');
        $user = User::find($user_id);

        $user->role_id = $request->input('cmb_edit_role');
        $user->name = $request->input('edit_name');
        $user->email = $request->input('edit_email');

        $user->save();

        return redirect()->route('users.index');
    }//update

    public function updatePassword(Request $request)
    {
        $user_id = $request->input('pwd_change_id');

        $user = User::find($user_id);
        $new_password = $request->input('new_password');

        $user->password = bcrypt($new_password);

        $user->save();

        return redirect()->route('users.index')->with('success', 'Password changed successfully!');
    }//update password
    
    //get one user
    public function getUser (Request $request)
    {
        $user_id = $request->input('user_id');

        $user = User::find($user_id);

        return response()->json($user);
    }//get one user
}//class
