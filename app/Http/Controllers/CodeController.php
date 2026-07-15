<?php

namespace App\Http\Controllers;

use App\Models\CampAccess;
use App\Models\Camps;
use App\Models\Codes;
use App\Models\Sheets;
use App\Services\GoogleSheetService;
use Google\Service\Sheets\Sheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CodeController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();
        $camps = CampAccess::where('user_id', $user_id)
            ->get();

        $active_camp_id = Session::get('active_camp_id');

        $codes = Codes::where('camp_id', $active_camp_id)
            ->orderBy('id', 'DESC')
            ->paginate(50);

        return view("codes.code_view", compact('camps', 'codes'));
    }

    public function codeUploadView()
    {
        $camps = Camps::where('status', 1)
            ->where('is_upload', 1)
            ->get();

        return view('codes.code_upload', compact('camps'));
    }//code upload view

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

        $sheet_id = $request->input('sheet_id');
        $sheet = Sheets::find($sheet_id);
        $sheet_name = $sheet->name;

        $sheet_service = new GoogleSheetService();

        $data = $sheet_service->getCodesByDate($sheet_link_id, $sheet_name, $sheet_date);

        $first = $data['data'][0];

        //check columns
        if(isset($first['Date']) && isset($first['Username']) && isset($first['Password']) && isset($first['Name']) && isset($first['Room No']) && isset($first['Amount']) && isset($first['Note']))
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
                    'note' => $dt['Note'],
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
        $user_id = Auth::id();
        $camp_id = $request->input('camp_id');
        $sheet_id = $request->input('sheet_id');
        $sheet_date = $request->input('sheet_date');

        //camp data
        $camp = Camps::find($camp_id);
        $sheet_link_id = $camp->sheetID;

        //sheet data
        $sheet = Sheets::find($sheet_id);
        $sheet_name = $sheet->name;

        $sheet_service = new GoogleSheetService();
        $data = $sheet_service->getCodesByDate($sheet_link_id, $sheet_name, $sheet_date);

        $first = $data['data'][0];
        
        //check columns
        if(isset($first['Date']) && isset($first['Username']) && isset($first['Password']) && isset($first['Name']) && isset($first['Room No']) && isset($first['Amount']) && isset($first['Note']))
        {
            foreach($data['data'] as $dt)
            {
                // check duplicates
                if($this->checkDuplicateCode($dt['Username'], $dt['Date'], $camp_id))
                {
                    continue;
                }//check duplicate

                Codes::create([
                    'camp_id' => $camp_id,
                    'sheet_id' => $sheet_id,
                    'issue_date' => $dt['Date'],
                    'submit_datetime' => now()->toDateTimeString(),
                    'username' => $dt['Username'],
                    'password' => $dt['Password'],
                    'customer_name' => $dt['Name'],
                    'room_no' =>$dt['Room No'],
                    'amount' =>$dt['Amount'],
                    'note' => $dt['Note'],
                    'status' => 1,
                    'user_id' => $user_id,
                ]);
            }//foreach

            return response()->json([
                'success' => true,
                'message' => 'Code uploaded successfully!'
            ]);
        }//has columns
        else{
            return response()->json([
                "success" => false,
                "message" => 'Column Header error, Please check columns headers!',
            ]);
        }//wrong column headers
    }//upload code

    private function checkDuplicateCode(string $code, string $sheet_date,string $camp_id)
    {
        $duplicate = Codes::where('issue_date', $sheet_date)
            ->where('username', $code)
            ->where('camp_id', $camp_id)
            ->exists();

        return $duplicate;
    }
}//class
