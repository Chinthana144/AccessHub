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
        $camps = Camps::where('status', 1)
            ->where('is_upload', 1)
            ->get();

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

    public function getCodesByDate(Request $request)
    {
        $sheet_date = $request->input("sheet_date");
        $camp_id = $request->input('camp_id');
        $camp = Camps::find($camp_id);
        $sheet_link_id = $camp->sheetID;
        $sheet_name = $request->input('sheet_name');

        $sheet_service = new GoogleSheetService();

        $data = $sheet_service->getCodesByDate($sheet_link_id, $sheet_name, $sheet_date);

        $first = $data['data'][0];

        //check columns
        if(isset($first['Date']) && isset($first['Username']) && isset($first['Password']) && isset($first['Name']) && isset($first['Room No']) && isset($first['Amount']))
        {
            $response = [];
            foreach($data['data'] as $dt)
            {
                $response[] = [
                    'date' => $dt['Date'],
                    'username' => $dt['Username'],
                    'password' => $dt['Password'],
                    'name' => $dt['Name'],
                    'room_no' => $dt['Room No'],
                    'amount' => $dt['Amount'],
                ];
            }//foreach

            return response()->json([
                "success" => true,
                "data" => $response,
            ]);
        }//all columns are set
        else{
            return response()->json([
                "success" => false,
                "message" => 'Column Header error, Please check columns headers!',
            ]);
        }//worng columns header
    }

    public function codeUpload(Request $request)
    {
        
    }
}//class
