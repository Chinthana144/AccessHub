<?php

namespace App\Http\Controllers;

use App\Models\Camps;
use App\Models\Codes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index()
    {
        $active_camp_id = Session::get('active_camp_id');

        $camp = Camps::find($active_camp_id);

        $last_code = Codes::orderBy('id', 'DESC')->first();

        if($last_code)
        {
            $issue_date = $last_code['issue_date'];

            $daily_sale = Codes::where('issue_date', $issue_date)
                ->where('camp_id', $active_camp_id)
                ->sum('amount');

            $daily_code_count = Codes::where('issue_date', $issue_date)
                ->where('camp_id', $active_camp_id)
                ->count('id');

            $month_start = date('Y-m-01', strtotime($issue_date));
            $month_end = date('Y-m-t', strtotime($issue_date));

            $month_sale = Codes::whereBetween('issue_date', [$month_start, $month_end])
                ->where('camp_id', $active_camp_id)
                ->sum('amount');

            $month_code_count = Codes::whereBetween('issue_date', [$month_start, $month_end])
                ->where('camp_id', $active_camp_id)
                ->count('id');

            return view('home', compact('camp', 'daily_sale', 'daily_code_count', 'month_sale', 'month_code_count'));
        }//has data
        else
        {
            $daily_sale = 0;
            $daily_code_count = 0;
            $month_sale = 0;
            $month_code_count = 0;
            return view('home', compact('camp', 'daily_sale', 'daily_code_count', 'month_sale', 'month_code_count'));
        }//no data
        
    }//index

    public function getAreaChartData(Request $request)
    {
        $camp_id = Session::get('active_camp_id');

        $data = Codes::selectRaw('issue_date, sum(amount) as total')
            ->groupBy('issue_date')
            ->where('camp_id', $camp_id)
            ->orderBy('issue_date', 'DESC')
            ->limit(30)
            ->get();

        $data = $data->reverse()->values();

        return response()->json($data);
    }//get area chart
}//class
