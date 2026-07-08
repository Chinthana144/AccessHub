<?php

namespace App\Http\Controllers;

use App\Models\Camps;
use App\Services\GoogleSheetService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CodeController extends Controller
{
    public function index()
    {
        $camps = Camps::where('status', 1)->get();

        return view("codes.code_view", compact('camps'));
    }

    public function getCodes(Request $request)
    {
        $camp_id = $request->input('camp_id');
        $camp = Camps::find($camp_id);
        $sheet_link_id = $camp->sheetID;
        $sheet_name = $request->input('sheet_name');

        $sheet_service = new GoogleSheetService();

        $sheet_data = $sheet_service->getCodes($sheet_link_id, $sheet_name);

        return response()->json($sheet_data);

    }//get codes
}//class
