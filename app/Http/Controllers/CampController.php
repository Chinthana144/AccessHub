<?php

namespace App\Http\Controllers;

use App\Models\Camps;
use Illuminate\Http\Request;

class CampController extends Controller
{
    public function index()
    {
        //fetch all camps
        $camps = Camps::where('status', 1)->paginate(10);

        return view('camp.camps_view', compact('camps'));
    }//index

    public function store(Request $request)
    {
        Camps::create([
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'contactPerson' => $request->input('contactPerson'),
            'contactNo' => $request->input('contactNo'),
            'mikrotikHost' => $request->input('mikrotikHost'),
            'mikrotikPort' => $request->input('mikrotikPort'),
            'mikrotikUsername' => $request->input('mikrotikUsername'),
            'mikrotikPassword' => $request->input('mikrotikPassword'),
            'sheetID' => $request->input('sheetID'),
            'status' => 1,
        ]);

        return redirect()->route('camps.index');
    }//store

    public function update(Request $request)
    {
        $camp_id = $request->input("hide_camp_id");
        $camp = Camps::find($camp_id);

        $camp->name = $request->input('name');
        $camp->address = $request->input('address');
        $camp->contactPerson = $request->input('contactPerson');
        $camp->contactNo = $request->input('contactNo');
        $camp->mikrotikHost = $request->input('mikrotikHost');
        $camp->mikrotikPort = $request->input('mikrotikPort');
        $camp->mikrotikUsername = $request->input('mikrotikUsername');
        $camp->mikrotikPassword = $request->input('mikrotikPassword');
        $camp->sheetID = $request->input('sheetID');

        $camp->save();

        return redirect()->route('camps.index');

    }//update

    //============================ AJAX ==========================//
    public function getOneCamp(Request $request)
    {
        $camp_id = $request->input("id");

        $camp = Camps::find($camp_id);

        return response()->json($camp);
    }
}
