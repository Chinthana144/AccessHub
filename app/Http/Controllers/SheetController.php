<?php

namespace App\Http\Controllers;

use App\Models\Camps;
use App\Models\Sheets;
use App\Services\GoogleSheetService;
use DateTime;
use Google\Service\Sheets\Sheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SheetController extends Controller
{
    public function index()
    {
        $camp_id = Session::get('active_camp_id');
        $camp = Camps::find($camp_id);

        $sheets = Sheets::paginate(10);

        return view('sheets.sheet_view', compact('sheets', 'camp'));
    }

    public function saveSheetNames(Request $request)
    {
        $camp_id = Session::get('active_camp_id');
        $sheets = $request->sheets;

        foreach($sheets as $sheet)
        {
            $sheet_name = $sheet['sheet_name'];
            $start_date = $sheet['start_date'];
            $end_date = $sheet['end_date'];
            $last_synced = date('Y-m-d H:i:s');
            $has_data = $sheet['has_code'] == 1 ? 1 : 0;

            //check name duplicates
            $name_duplicate_exist = Sheets::where("name", $sheet_name)->exists();
            
            if(!$name_duplicate_exist)
            {
                //check startdate and end date
                $sheet_name = Sheets::where("start_date" , $start_date)
                    ->where('end_date', $end_date)
                    ->first();

                if($sheet_name)
                {
                    $sheet_name_id = $sheet_name->id;
                    $old_sheet = Sheets::find($sheet_name_id);
                    $old_sheet->name = $sheet_name;
                    $old_sheet->last_synced_at = $last_synced;

                    $old_sheet->save();
                }//data exists

                Sheets::create([
                    'camp_id' => $camp_id,
                    'name' => $sheet_name,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'last_synced_at' => $last_synced,
                    'has_data' => $has_data,
                    'status' => 0,
                ]);
            }//name 
        }//foreach

        return response()->json([
            'success' => true,
            'message' => 'Sheet synchronized successfully!'
        ]);
    }//save sheet names

    public function getSheetByID(Request $request)
    {
        $sheet_id = $request->sheetID;

        $sheet = Sheets::find($sheet_id);

        return response()->json($sheet);
    }//get sheet by id

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
