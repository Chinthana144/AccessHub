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
}
