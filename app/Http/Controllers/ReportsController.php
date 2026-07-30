<?php

namespace App\Http\Controllers;

use App\Models\CampAccess;
use App\Models\Camps;
use App\Models\Codes;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportsController extends Controller
{
    public function index()
    {
        return view('reports.report_view');
    }//index

    public function salesDetailReport()
    {
        $user_id = Auth::id();
        $user_camps = CampAccess::where('user_id', $user_id)->get();

        $camp_id = $user_camps[0]->id;

        return view('reports.sales_detail_view', compact('user_camps', 'camp_id'));
    }//sales detail view

    public function rptSalesDetail(Request $request)
    {
        $camp_id = $request->input('cmb_camp');
        $camp = Camps::find($camp_id);

        $user_id = Auth::id();
        $user_camps = CampAccess::where('user_id', $user_id)->get();

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $data = Codes::where('camp_id', $camp_id)
            ->whereBetween('issue_date', [$start_date, $end_date])
            ->get();

        switch ($request->action) {
            case 'search':   
                return view('reports.sales_detail_view', compact('user_camps', 'data', 'camp_id', 'start_date', 'end_date'));
            break;

            //pdf
            case 'pdf':
                $data = Codes::where('camp_id', $camp_id)
                    ->whereBetween('issue_date', [$start_date, $end_date])
                    ->get();

                $pdf = Pdf::loadView('pdf.rptSalesDetail', compact('data', 'camp', 'camp_id', 'start_date', 'end_date'));

                return $pdf->stream('sales_detail_from_'. $start_date." to ". $end_date .'.pdf');
            break;
            
            default:
                # code...
                break;
        }
    }//sales detail report

    public function saleSummartReport()
    {
        $user_id = Auth::id();
        $user_camps = CampAccess::where('user_id', $user_id)->get();

        $camp_id = $user_camps[0]->id;

        return view('reports.sales_summary_view', compact('user_camps', 'camp_id'));
    }//sales summary report

    public function rptSaleSummary(Request $request)
    {
        $camp_id = $request->input('cmb_camp');
        $camp = Camps::find($camp_id);

        $user_id = Auth::id();
        $user_camps = CampAccess::where('user_id', $user_id)->get();

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $days = Codes::select('issue_date')
            ->where('camp_id', $camp_id)
            ->whereBetween('issue_date', [$start_date, $end_date])
            ->groupBy('issue_date')
            ->get();

        $data = [];    

        foreach ($days as $day) 
        {
            $price_30_count = Codes::where('camp_id', $camp_id)
                ->where('issue_date', $day['issue_date'])
                ->where('amount', 30)
                ->count('amount');

            $price_15_count = Codes::where('camp_id', $camp_id)
                ->where('issue_date', $day['issue_date'])
                ->where('amount', 15)
                ->count('amount');

            $free_count = Codes::where('camp_id', $camp_id)
                ->where('issue_date', $day['issue_date'])
                ->where('amount', 0)
                ->count('amount');

            $total_count = Codes::where('camp_id', $camp_id)
                ->where('issue_date', $day['issue_date'])               
                ->count('amount');

            $data[] = [
                $day['issue_date'],
                $price_30_count,
                $price_15_count,
                $free_count,
                $total_count
            ];
        }//foreach
        
        //action
        switch ($request->action) {
            case 'search':
                return view('reports.sales_summary_view', compact('user_camps', 'camp_id', 'start_date', 'end_date', 'data'));
            break;
            
            case 'pdf' : 
                $pdf = Pdf::loadView('pdf.rptSaleSummary', compact('data', 'camp', 'camp_id', 'start_date', 'end_date'));

                return $pdf->stream('sale_summary_from_'. $start_date." to ". $end_date .'.pdf');
            break;
            default:
                # code...
            break;
        }

        
    }//rpt sale summary
}//class
