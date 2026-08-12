<?php

namespace App\Http\Controllers;

use App\Models\Camps;
use App\Models\Sheets;
use App\Services\GoogleSheetService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

class SheetController extends Controller
{
    public function index()
    {
        $camps = Camps::where('status', 1)
            ->where('is_upload', 1)
            ->get();
        $active_camp_id = Session::get('active_camp_id');
        $camp = Camps::find($active_camp_id);

        $sheets = Sheets::where('camp_id', $active_camp_id)
            ->orderBy('start_date', 'DESC')    
            ->paginate(10);

        return view('sheets.sheet_view', compact('sheets', 'camp', 'camps', 'active_camp_id'));
    }

    public function saveSheetNames(Request $request)
    {
        $sheets = $request->sheets;

        foreach($sheets as $sheet)
        {
            $camp_id = $sheet['camp_id'];
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
                $sheet_tab = Sheets::where("start_date" , $start_date)
                    ->where('end_date', $end_date)
                    ->first();

                if($sheet_tab)
                {
                    $sheet_name_id = $sheet_tab->id;
                    $old_sheet = Sheets::find($sheet_name_id);
                    $old_sheet->name = $sheet_name;
                    $old_sheet->last_synced_at = $last_synced;

                    $old_sheet->save();
                }//data exists
                else
                {
                    Sheets::create([
                        'camp_id' => $camp_id,
                        'name' => $sheet_name,
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                        'last_synced_at' => $last_synced,
                        'has_data' => $has_data,
                        'status' => 0,
                    ]);
                }//else
            }//name 
        }//foreach

        return response()->json([
            'success' => true,
            'message' => 'Sheet synchronized successfully!'
        ]);
    }//save sheet names

    public function update(Request $request, Sheets $sheet)
    {
        try {
            $this->authorize('update', $sheet);

            $sheet_id = $request->input('hide_sheet_id');

            $sheet = Sheets::find($sheet_id);

            $sheet->start_date = $request->input('start_date');
            $sheet->end_date = $request->input('end_date');

            $has_code = $request->has('chk_has_code');
            $status = $request->has('chk_active_sheet');

            $sheet->has_data = $has_code ? 1 : 0;
            $sheet->status = $status ? 1 : 0;

            $sheet->save();

            return redirect()->route('sheets.index')->with('success', 'Sheet updated successfully!');
        } catch (\Throwable $th) {
            return redirect()->route('sheets.index')->with('error', 'You are not authorized to update this sheet!');
        }
        
    }//update sheet

    public function destroy(Request $request, Sheets $sheet)
    {
        try {
            $this->authorize('delete', $sheet);

            $sheet_id = $request->input('sheet_id');
            $sheet = Sheets::find($sheet_id);

            $sheet->delete();

            return response()->json([
                'success' => true,
                'message' => 'Sheet removed successfully!',
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to update this sheet!',
            ]);
        }
    }//destroy

    public function getSheetByID(Request $request)
    {
        $sheet_id = $request->sheetID;

        $sheet = Sheets::find($sheet_id);

        return response()->json($sheet);
    }//get sheet by id

    public function getSheetByCampID(Request $request)
    {
        // $user = Auth::user();
        // $role_id = $user->role->id;
        $camp_id = $request->input('camp_id');

        $sheets = Sheets::where('camp_id', $camp_id)
            ->orderBy("start_date", "DESC")
            ->get();

        return response()->json($sheets);
    }//get sheet by camp id

    public function getActiveSheetByCampID(Request $request)
    {
        $camp_id = $request->input('camp_id');

        $sheets = Sheets::where('camp_id', $camp_id)
            ->where('status', 1)
            ->where('has_data', 1)
            ->get();

        return response()->json($sheets);
    }//get active sheets

    public function getActiveSheets(Request $request)
    {
        $camp_id = $request->input('camp_id');
        $sheets = Sheets::where('camp_id', $camp_id)
            ->where('status', 1)
            ->get();

        return response()->json($sheets);
    }//get active sheets

    public function fetchGoogleSheets(Request $request)
    {

        $camp_id = $request->input('camp_id');
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
