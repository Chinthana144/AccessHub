<?php

namespace App\Http\Controllers;

use App\Models\CampAccess;
use App\Models\Camps;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CampAccessController extends Controller
{
    public function index()
    {
        $camps = Camps::where('status', 1)->get();
        $users = User::all();

        $camp_accesses = CampAccess::paginate(10);

        return view('campAccess.camp_access_view', compact('camps', 'users', 'camp_accesses'));
    }//index

    public function store(Request $request)
    {
        $user_id = $request->input('user_id');
        $camp_id = $request->input('camp_id');

        $has_duplicates = CampAccess::where('user_id', $user_id)
            ->where('camp_id', $camp_id)
            ->exists();

        if(!$has_duplicates)
        {
            //create
            CampAccess::create([
                'user_id' => $user_id,
                'camp_id' => $camp_id,
            ]);

            return redirect()->route('campAccess.index')
                ->with('success', 'Access created successfully!');
        }
        else
        {
            return redirect()->route('campAccess.index')
                ->with('duplicate', 'Camp access already exists!');  
        }
    }//store

    public function remove(Request $request)
    {
        $camp_access_id = $request->input('camp_access_id');

        $camp_access = CampAccess::find($camp_access_id);

        $camp_access->delete();

        return redirect()->route('campAccess.index')
            ->with('remove', 'Access removed successfully!');
    }//remove

    public function campPortal()
    {
        $user_id = Auth::id();
        $user_camps = CampAccess::where('user_id', $user_id)->get();

        return view('camp_portal', compact('user_camps'));
    }//camp portal

    public function gotoCamp(Request $request)
    {
        $camp_id = $request->route('camp_id');
        Session::put('active_camp_id', $camp_id);

        return redirect()->route('home');
    }

}//class
