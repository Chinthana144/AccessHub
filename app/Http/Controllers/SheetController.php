<?php

namespace App\Http\Controllers;

use App\Models\Camps;
use App\Models\Sheets;
use App\Services\GoogleSheetService;
use Google\Service\Sheets\Sheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SheetController extends Controller
{
    public function index()
    {
        $camp_id = Session::get('active_camp_id');
        $camp = Camps::find($camp_id);

        return view('sheets.sheet_view', compact('camp'));
    }

    public function fetchGoogleSheets()
    {
        $camp_id = Session::get('active_camp_id');
        $camp = Camps::find($camp_id);
        $sheet_id = $camp->sheetID;

        $sheet_service = new GoogleSheetService();

        $sheet_names = $sheet_service->getSheetNames($sheet_id);

        $new_sheets = [];

        foreach ($sheet_names as $sheet) 
        {
            $sheet_name = $sheet;

            $name_exist = Sheets::where('camp_id', $camp_id)
                ->where('name', $sheet_name)
                ->exists();

            if($name_exist)
            {
                continue;   
            }
            else
            {
                $new_sheets[] = $sheet_name;
            }
        }//foreach

        return response()->json($new_sheets);

    }//fetch sheets
}//class
