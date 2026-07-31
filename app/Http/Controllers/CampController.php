<?php

namespace App\Http\Controllers;

use App\Models\Camps;
use Illuminate\Http\Request;

class CampController extends Controller
{
    public function index()
    {
        //fetch all camps
        $camps = Camps::paginate(10);

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
            'is_upload' => $request->has('chk_upload_sheet') ? 1 : 0,
            'status' => $request->has('chk_active') ? 1 : 0,
        ]);

        return redirect()->route('camps.index');
    }//store

    public function update(Request $request, Camps $camp)
    {
        try {
            $this->authorize('update', $camp);
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
            $camp->is_upload = $request->has('chk_edit_upload_sheet') ? 1 : 0;
            $camp->status = $request->has('chk_edit_active') ? 1 : 0;

            $camp->save();

            return redirect()->route('camps.index')->with('success', 'Camp updated successfully!');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('camps.index')->with('error', 'You are not authorized to update camp!');
        }
    }//update

    //============================ AJAX ==========================//
    public function getOneCamp(Request $request)
    {
        $camp_id = $request->input("id");

        $camp = Camps::find($camp_id);

        return response()->json($camp);
    }
}
